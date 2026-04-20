<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AutoGroupProducts extends Command
{
    protected $signature = 'products:auto-group {--dry-run : Show what would change without writing}';

    protected $description = 'Detect size/variant suffixes in product names and populate group_slug, variant_label, group_sort';

    public function handle(): int
    {
        $sizeOrder = [
            'small' => 1, 's' => 1,
            'medium' => 2, 'm' => 2,
            'large' => 3, 'l' => 3,
            'extra large' => 4, 'xl' => 4,
            'xxl' => 5,
        ];
        $suffixPattern = '/\s*[-–—]\s*(Extra Large|Small|Medium|Large|XXL|XL|S|M|L)\s*$/i';

        $products = Product::all();
        $groups = [];

        foreach ($products as $p) {
            if (! preg_match($suffixPattern, $p->name, $m)) continue;
            $base = trim(preg_replace($suffixPattern, '', $p->name));
            if ($base === '') continue;
            $label = trim($m[1]);
            $groups[$base][] = ['product' => $p, 'label' => $label];
        }

        $dry = (bool) $this->option('dry-run');
        $updated = 0;
        $groupsWritten = 0;

        foreach ($groups as $base => $members) {
            if (count($members) < 2) continue;

            $slug = Str::slug($base);
            $groupsWritten++;

            foreach ($members as $entry) {
                $p = $entry['product'];
                $label = $entry['label'];
                $order = $sizeOrder[strtolower($label)] ?? 99;

                $changed = $p->group_slug !== $slug
                    || $p->variant_label !== $label
                    || (int) $p->group_sort !== $order;

                if (! $changed) continue;

                $this->line(sprintf(
                    '  %s  →  group=%s  label=%s  sort=%d',
                    $p->name, $slug, $label, $order
                ));

                if (! $dry) {
                    $p->group_slug = $slug;
                    $p->variant_label = $label;
                    $p->group_sort = $order;
                    $p->save();
                }
                $updated++;
            }
        }

        $this->info(sprintf(
            '%s %d products across %d groups%s.',
            $dry ? 'Would update' : 'Updated',
            $updated,
            $groupsWritten,
            $dry ? ' (dry run — no changes written)' : ''
        ));

        return self::SUCCESS;
    }
}
