<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        $settings = Setting::allCached();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone'           => 'nullable|string|max:30',
            'phone_secondary' => 'nullable|string|max:30',
            'email'           => 'nullable|email|max:255',
            'whatsapp'        => 'nullable|string|max:30',
            'address'         => 'nullable|string|max:500',
            'city'            => 'nullable|string|max:100',
            'google_maps_url' => 'nullable|url|max:1000',
            'facebook_url'    => 'nullable|url|max:500',
            'instagram_url'   => 'nullable|url|max:500',
            'tiktok_url'      => 'nullable|url|max:500',
            'linkedin_url'    => 'nullable|url|max:500',
            'twitter_url'     => 'nullable|url|max:500',
            'youtube_url'     => 'nullable|url|max:500',
            'pinterest_url'   => 'nullable|url|max:500',
        ]);

        $keys = [
            'phone', 'phone_secondary', 'email', 'whatsapp',
            'address', 'city', 'google_maps_url',
            'facebook_url', 'instagram_url', 'tiktok_url',
            'linkedin_url', 'twitter_url', 'youtube_url', 'pinterest_url',
        ];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Settings saved successfully.');
    }
}
