<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\QuoteRequest;

class ExportController extends Controller
{
    public function products()
    {
        $products = Product::with('categories')->orderBy('name')->get();

        $csv = "ID,Name,SKU,Price,Stock Status,Type,Categories,Featured,Active\n";
        foreach ($products as $p) {
            $cats = $p->categories->pluck('name')->join('; ');
            $csv .= "\"{$p->id}\",\"{$p->name}\",\"{$p->sku}\",\"{$p->price}\",\"{$p->stock_status}\",\"{$p->product_type}\",\"{$cats}\",\"" . ($p->is_featured ? 'Yes' : 'No') . "\",\"" . (($p->is_active ?? true) ? 'Yes' : 'No') . "\"\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products-' . date('Y-m-d') . '.csv"',
        ]);
    }

    public function quotes()
    {
        $quotes = QuoteRequest::latest()->get();

        $csv = "Ref,Name,Email,Phone,Company,Items,Estimated Total,Status,Date\n";
        foreach ($quotes as $q) {
            $items = is_array($q->items) ? count($q->items) : 0;
            $csv .= "\"#QR-" . str_pad($q->id, 5, '0', STR_PAD_LEFT) . "\",\"{$q->name}\",\"{$q->email}\",\"{$q->phone}\",\"{$q->company}\",\"{$items}\",\"\${$q->estimated_total}\",\"{$q->status}\",\"{$q->created_at->format('Y-m-d')}\"\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="quotes-' . date('Y-m-d') . '.csv"',
        ]);
    }
}
