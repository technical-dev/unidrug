<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;

class QuotePdfController extends Controller
{
    public function download(QuoteRequest $quote)
    {
        $html = view('admin.quotes.pdf', compact('quote'))->render();

        // Use simple HTML-to-PDF approach without external packages
        return response($html, 200, [
            'Content-Type'        => 'text/html',
            'Content-Disposition' => 'inline; filename="quote-QR-' . str_pad($quote->id, 5, '0', STR_PAD_LEFT) . '.html"',
        ]);
    }

    public function printView(QuoteRequest $quote)
    {
        return view('admin.quotes.pdf', compact('quote'));
    }
}
