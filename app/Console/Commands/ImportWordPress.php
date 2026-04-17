<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\Tag;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[Signature('app:import-wordpress {--fresh : Truncate all tables before import}')]
#[Description('Import data from the WordPress unidrug_wp_dataB database')]
class ImportWordPress extends Command
{
    protected string $wpDb = 'unidrug_wp_dataB';

    public function handle(): int
    {
        if ($this->option('fresh')) {
            $this->info('Truncating all tables...');
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table('category_product')->truncate();
            DB::table('product_tag')->truncate();
            ProductImage::truncate();
            ProductVariation::truncate();
            Product::truncate();
            Category::truncate();
            Tag::truncate();
            Page::truncate();
            Post::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $this->importCategories();
        $this->importTags();
        $this->importProducts();
        $this->importVariations();
        $this->importProductImages();
        $this->importProductCategories();
        $this->importPages();
        $this->importPosts();

        $this->newLine();
        $this->info('✅ WordPress import complete!');
        $this->table(
            ['Table', 'Count'],
            [
                ['categories', Category::count()],
                ['products', Product::count()],
                ['product_variations', ProductVariation::count()],
                ['product_images', ProductImage::count()],
                ['tags', Tag::count()],
                ['pages', Page::count()],
                ['posts', Post::count()],
            ]
        );

        return self::SUCCESS;
    }

    protected function wp(string $table): \Illuminate\Database\Query\Builder
    {
        return DB::connection('wordpress')->table($table);
    }

    protected function importCategories(): void
    {
        $this->info('Importing categories...');

        $terms = $this->wp('wp_terms as t')
            ->join('wp_term_taxonomy as tt', 't.term_id', '=', 'tt.term_id')
            ->where('tt.taxonomy', 'product_cat')
            ->select('t.term_id', 't.name', 't.slug', 'tt.description', 'tt.parent')
            ->orderBy('tt.parent')
            ->orderBy('t.name')
            ->get();

        // Get category images from wp_termmeta
        $categoryImages = $this->wp('wp_termmeta')
            ->where('meta_key', 'thumbnail_id')
            ->whereIn('term_id', $terms->pluck('term_id'))
            ->pluck('meta_value', 'term_id');

        // Resolve attachment URLs
        $attachmentIds = $categoryImages->values()->filter()->unique()->toArray();
        $attachmentUrls = [];
        if (!empty($attachmentIds)) {
            $attachmentUrls = $this->wp('wp_posts')
                ->whereIn('ID', $attachmentIds)
                ->pluck('guid', 'ID')
                ->toArray();
        }

        // Map wp_term_id to new category id
        $termMap = [];

        // First pass: create all categories without parent
        foreach ($terms as $term) {
            $imageUrl = null;
            if (isset($categoryImages[$term->term_id]) && isset($attachmentUrls[$categoryImages[$term->term_id]])) {
                $imageUrl = $attachmentUrls[$categoryImages[$term->term_id]];
            }

            $cat = Category::create([
                'name' => html_entity_decode($term->name, ENT_QUOTES, 'UTF-8'),
                'slug' => $term->slug,
                'description' => $term->description ?: null,
                'image' => $imageUrl,
                'parent_id' => null,
                'is_active' => true,
                'wp_term_id' => $term->term_id,
            ]);
            $termMap[$term->term_id] = $cat->id;
        }

        // Second pass: set parent_id
        foreach ($terms as $term) {
            if ($term->parent > 0 && isset($termMap[$term->parent]) && isset($termMap[$term->term_id])) {
                Category::where('id', $termMap[$term->term_id])
                    ->update(['parent_id' => $termMap[$term->parent]]);
            }
        }

        $this->info("  → {$terms->count()} categories imported.");
    }

    protected function importTags(): void
    {
        $this->info('Importing tags...');

        $terms = $this->wp('wp_terms as t')
            ->join('wp_term_taxonomy as tt', 't.term_id', '=', 'tt.term_id')
            ->where('tt.taxonomy', 'product_tag')
            ->select('t.term_id', 't.name', 't.slug')
            ->orderBy('t.name')
            ->get();

        foreach ($terms as $term) {
            Tag::create([
                'name' => html_entity_decode($term->name, ENT_QUOTES, 'UTF-8'),
                'slug' => $term->slug,
                'wp_term_id' => $term->term_id,
            ]);
        }

        $this->info("  → {$terms->count()} tags imported.");
    }

    protected function importProducts(): void
    {
        $this->info('Importing products...');

        $products = $this->wp('wp_posts')
            ->where('post_type', 'product')
            ->whereIn('post_status', ['publish', 'draft', 'private'])
            ->select('ID', 'post_title', 'post_name', 'post_content', 'post_excerpt', 'post_status')
            ->orderBy('ID')
            ->get();

        $bar = $this->output->createProgressBar($products->count());

        foreach ($products as $wp) {
            $meta = $this->getPostMeta($wp->ID);

            // Determine product type
            $productType = 'simple';
            $typeTerms = $this->wp('wp_term_relationships as tr')
                ->join('wp_term_taxonomy as tt', 'tr.term_taxonomy_id', '=', 'tt.term_taxonomy_id')
                ->join('wp_terms as t', 'tt.term_id', '=', 't.term_id')
                ->where('tr.object_id', $wp->ID)
                ->where('tt.taxonomy', 'product_type')
                ->pluck('t.slug');
            if ($typeTerms->contains('variable')) {
                $productType = 'variable';
            }

            // Get featured image URL
            $featuredImage = null;
            if (!empty($meta['_thumbnail_id'])) {
                $featuredImage = $this->getAttachmentUrl((int) $meta['_thumbnail_id']);
            }

            // Get the min price for display (WooCommerce stores min price in _price for variable products)
            $price = $meta['_regular_price'] ?? $meta['_price'] ?? null;
            $salePrice = $meta['_sale_price'] ?? null;

            Product::create([
                'name' => html_entity_decode($wp->post_title, ENT_QUOTES, 'UTF-8'),
                'slug' => $wp->post_name ?: Str::slug($wp->post_title),
                'short_description' => $wp->post_excerpt ?: null,
                'description' => $wp->post_content ?: null,
                'sku' => $meta['_sku'] ?? null,
                'price' => is_numeric($price) ? $price : null,
                'sale_price' => is_numeric($salePrice) ? $salePrice : null,
                'product_type' => $productType,
                'stock_status' => $meta['_stock_status'] ?? 'instock',
                'stock_quantity' => isset($meta['_stock']) && is_numeric($meta['_stock']) ? (int) $meta['_stock'] : null,
                'weight' => isset($meta['_weight']) && is_numeric($meta['_weight']) ? $meta['_weight'] : null,
                'featured_image' => $featuredImage,
                'category_id' => null, // using pivot table instead
                'status' => $wp->post_status === 'publish' ? 'active' : 'draft',
                'is_featured' => ($meta['_featured'] ?? 'no') === 'yes',
                'wp_post_id' => $wp->ID,
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  → {$products->count()} products imported.");
    }

    protected function importVariations(): void
    {
        $this->info('Importing product variations...');

        $variations = $this->wp('wp_posts')
            ->where('post_type', 'product_variation')
            ->whereIn('post_status', ['publish', 'private'])
            ->select('ID', 'post_parent', 'post_title', 'post_name', 'menu_order')
            ->orderBy('post_parent')
            ->orderBy('menu_order')
            ->get();

        // Build parent product map: wp_post_id -> product.id
        $productMap = Product::pluck('id', 'wp_post_id')->toArray();

        $imported = 0;
        $bar = $this->output->createProgressBar($variations->count());

        foreach ($variations as $v) {
            if (!isset($productMap[$v->post_parent])) {
                $bar->advance();
                continue;
            }

            $meta = $this->getPostMeta($v->ID);

            // Get attribute info
            $attrName = null;
            $attrValue = null;
            if (!empty($meta['attribute_pa_types'])) {
                $attrName = 'pa_types';
                $attrValue = $meta['attribute_pa_types'];
            } elseif (!empty($meta['attribute_pa_sizes'])) {
                $attrName = 'pa_sizes';
                $attrValue = $meta['attribute_pa_sizes'];
            }

            $price = $meta['_regular_price'] ?? $meta['_price'] ?? null;
            $salePrice = $meta['_sale_price'] ?? null;

            // Get variation image
            $image = null;
            if (!empty($meta['_thumbnail_id'])) {
                $image = $this->getAttachmentUrl((int) $meta['_thumbnail_id']);
            }

            ProductVariation::create([
                'product_id' => $productMap[$v->post_parent],
                'name' => html_entity_decode($v->post_title, ENT_QUOTES, 'UTF-8'),
                'sku' => $meta['_sku'] ?? null,
                'price' => is_numeric($price) ? $price : null,
                'sale_price' => is_numeric($salePrice) ? $salePrice : null,
                'attribute_name' => $attrName,
                'attribute_value' => $attrValue,
                'stock_status' => $meta['_stock_status'] ?? 'instock',
                'stock_quantity' => isset($meta['_stock']) && is_numeric($meta['_stock']) ? (int) $meta['_stock'] : null,
                'image' => $image,
                'sort_order' => $v->menu_order ?? 0,
                'wp_post_id' => $v->ID,
            ]);

            $imported++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  → {$imported} variations imported.");
    }

    protected function importProductImages(): void
    {
        $this->info('Importing product gallery images...');

        $products = Product::whereNotNull('wp_post_id')->get(['id', 'wp_post_id']);
        $imported = 0;

        foreach ($products as $product) {
            $gallery = $this->wp('wp_postmeta')
                ->where('post_id', $product->wp_post_id)
                ->where('meta_key', '_product_image_gallery')
                ->value('meta_value');

            if (empty($gallery)) {
                continue;
            }

            $attachmentIds = array_filter(explode(',', $gallery));
            $sort = 0;

            foreach ($attachmentIds as $attachmentId) {
                $url = $this->getAttachmentUrl((int) $attachmentId);
                if ($url) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'url' => $url,
                        'alt' => null,
                        'sort_order' => $sort++,
                    ]);
                    $imported++;
                }
            }
        }

        $this->info("  → {$imported} gallery images imported.");
    }

    protected function importProductCategories(): void
    {
        $this->info('Importing product-category relationships...');

        $productMap = Product::pluck('id', 'wp_post_id')->toArray();
        $categoryMap = Category::pluck('id', 'wp_term_id')->toArray();

        $relationships = $this->wp('wp_term_relationships as tr')
            ->join('wp_term_taxonomy as tt', 'tr.term_taxonomy_id', '=', 'tt.term_taxonomy_id')
            ->where('tt.taxonomy', 'product_cat')
            ->select('tr.object_id', 'tt.term_id')
            ->get();

        $pivotData = [];
        foreach ($relationships as $rel) {
            if (isset($productMap[$rel->object_id]) && isset($categoryMap[$rel->term_id])) {
                $pivotData[] = [
                    'product_id' => $productMap[$rel->object_id],
                    'category_id' => $categoryMap[$rel->term_id],
                ];
            }
        }

        // Insert in chunks to avoid duplicates
        $unique = collect($pivotData)->unique(fn ($item) => $item['product_id'] . '-' . $item['category_id']);
        foreach ($unique->chunk(500) as $chunk) {
            DB::table('category_product')->insert($chunk->toArray());
        }

        $this->info("  → {$unique->count()} product-category links imported.");
    }

    protected function importPages(): void
    {
        $this->info('Importing pages...');

        // Only import meaningful pages (not WooCommerce system pages)
        $excludeSlugs = ['cart', 'checkout', 'my-account', 'wishlist', 'shop', 'my-orders',
                         'order-tracking', 'store-list', 'compare', 'all-products'];

        $pages = $this->wp('wp_posts')
            ->where('post_type', 'page')
            ->where('post_status', 'publish')
            ->whereNotIn('post_name', $excludeSlugs)
            ->where('post_title', 'NOT LIKE', 'Elementor%')
            ->select('ID', 'post_title', 'post_name', 'post_content', 'post_status')
            ->orderBy('ID')
            ->get();

        foreach ($pages as $page) {
            Page::create([
                'title' => html_entity_decode($page->post_title, ENT_QUOTES, 'UTF-8'),
                'slug' => $page->post_name ?: Str::slug($page->post_title),
                'content' => $page->post_content ?: null,
                'status' => 'published',
                'wp_post_id' => $page->ID,
            ]);
        }

        $this->info("  → {$pages->count()} pages imported.");
    }

    protected function importPosts(): void
    {
        $this->info('Importing blog posts...');

        $posts = $this->wp('wp_posts')
            ->where('post_type', 'post')
            ->whereIn('post_status', ['publish', 'draft'])
            ->select('ID', 'post_title', 'post_name', 'post_content', 'post_excerpt', 'post_status')
            ->orderBy('ID')
            ->get();

        foreach ($posts as $wp) {
            $meta = $this->getPostMeta($wp->ID);
            $featuredImage = null;
            if (!empty($meta['_thumbnail_id'])) {
                $featuredImage = $this->getAttachmentUrl((int) $meta['_thumbnail_id']);
            }

            Post::create([
                'title' => html_entity_decode($wp->post_title, ENT_QUOTES, 'UTF-8'),
                'slug' => $wp->post_name ?: Str::slug($wp->post_title),
                'content' => $wp->post_content ?: null,
                'excerpt' => $wp->post_excerpt ?: null,
                'featured_image' => $featuredImage,
                'status' => $wp->post_status === 'publish' ? 'published' : 'draft',
                'wp_post_id' => $wp->ID,
            ]);
        }

        $this->info("  → {$posts->count()} blog posts imported.");
    }

    /**
     * Get all meta values for a post as key => value array.
     * For duplicate keys, takes the first value.
     */
    protected function getPostMeta(int $postId): array
    {
        $rows = $this->wp('wp_postmeta')
            ->where('post_id', $postId)
            ->select('meta_key', 'meta_value')
            ->get();

        $meta = [];
        foreach ($rows as $row) {
            if (!isset($meta[$row->meta_key])) {
                $meta[$row->meta_key] = $row->meta_value;
            }
        }

        return $meta;
    }

    /**
     * Get full URL for a WP attachment by ID.
     */
    protected function getAttachmentUrl(int $attachmentId): ?string
    {
        static $cache = [];

        if (isset($cache[$attachmentId])) {
            return $cache[$attachmentId];
        }

        $url = $this->wp('wp_posts')
            ->where('ID', $attachmentId)
            ->value('guid');

        $cache[$attachmentId] = $url ?: null;

        return $cache[$attachmentId];
    }
}
