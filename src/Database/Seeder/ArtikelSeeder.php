<?php

namespace Ombimo\LarawebArtikel\Database\Seeder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ombimo\LarawebArtikel\Models\Artikel;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $dataArtikel = Artikel::factory()->count(20)->create();
    }
}
