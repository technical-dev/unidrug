<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::latest();

        if ($search = $request->search) {
            $query->where('email', 'like', "%{$search}%");
        }

        $subscribers = $query->paginate(30)->withQueryString();
        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function export()
    {
        $subscribers = Subscriber::where('is_active', true)->orderBy('email')->get();

        $csv = "Email,Name,Subscribed Date\n";
        foreach ($subscribers as $s) {
            $csv .= "\"{$s->email}\",\"{$s->name}\",\"{$s->created_at->format('Y-m-d')}\"\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="subscribers-' . date('Y-m-d') . '.csv"',
        ]);
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber removed!');
    }
}
