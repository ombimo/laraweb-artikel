<?php
namespace Ombimo\LarawebArtikel\Database\Factories;

use Ombimo\LarawebArtikel\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArtikelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Artikel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($this->faker));
        $dir = storage_path().'\app\public\faker';

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $judul = $this->faker->text(100);
        $img = $this->faker->image($dir, $width = 640, $height = 480);
        $img = str_replace(storage_path()."\app\public\\", '', $img);
        $allowTags = '<a><br></br><p><span><h1><h2><h3><h4><h5><ul><li><ol><b><i><strong><em>';
        $isi = $this->faker->randomHtml();

        return [
            'judul' => $judul,
            'slug' => Str::slug($judul),
            'cover' => $img,
            'isi' => strip_tags($isi, $allowTags),
            'sinopsis' => substr(strip_tags($isi), 0, 180),
        ];
    }
}

