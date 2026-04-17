<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed defaults
        $defaults = [
            'phone'          => '',
            'phone_secondary'=> '',
            'email'          => 'info@unidrug.com',
            'whatsapp'       => '',
            'address'        => '',
            'city'           => 'Lebanon',
            'google_maps_url'=> '',
            'facebook_url'   => '',
            'instagram_url'  => '',
            'tiktok_url'     => '',
            'linkedin_url'   => '',
            'twitter_url'    => '',
            'youtube_url'    => '',
            'pinterest_url'  => '',
        ];

        foreach ($defaults as $key => $value) {
            DB::table('settings')->insert([
                'key'        => $key,
                'value'      => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
