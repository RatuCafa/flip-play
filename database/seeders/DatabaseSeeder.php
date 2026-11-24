<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user default (ID = 1) untuk pengujian watchlist
        User::factory()->create([
            'name' => 'Queen',
            'email' => 'queen@flipplay.test',
        ]);

        // Buat data awal media
        Media::create([
            'title' => 'Frieren: Beyond Journey\'s End',
            'type' => 'Anime',
            'genre' => 'Adventure / Fantasy',
            'rating' => 9.1,
            'summary' => 'Petualangan penyihir elf Frieren memahami makna kehidupan manusia.',
        ]);

        Media::create([
            'title' => 'Under the Dome',
            'type' => 'Series',
            'genre' => 'Drama / Sci-Fi',
            'rating' => 6.5,
            'summary' => 'Sebuah kota kecil tiba-tiba terisolasi di bawah kubah transparan raksasa.',
        ]);
    }
}