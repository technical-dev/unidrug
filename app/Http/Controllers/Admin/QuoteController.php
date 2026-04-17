<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $query = QuoteRequest::query();

        if ($status = $request->status) {
            $query->where('status', $status);
        }

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        $quotes = $query->latest()->paginate(20)->withQueryString();

        return view('admin.quotes.index', compact('quotes'));
    }

    public function show(QuoteRequest $quote)
    {
        return view('admin.quotes.show', compact('quote'));
    }

    public function updateStatus(Request $request, QuoteRequest $quote)
    {
        $request->validate([
            'status'      => 'required|in:pending,reviewed,quoted,accepted,rejected',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $quote->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Quote status updated!');
    }

    public function destroy(QuoteRequest $quote)
    {
        $quote->delete();
        return redirect()->route('admin.quotes.index')->with('success', 'Quote deleted!');
    }
}
