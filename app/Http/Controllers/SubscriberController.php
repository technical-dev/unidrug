<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        Subscriber::firstOrCreate(
            ['email' => $request->email],
            ['name' => $request->name]
        );

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Subscribed successfully!']);
        }

        return back()->with('success', 'You\'ve been subscribed to our newsletter!');
    }
}
