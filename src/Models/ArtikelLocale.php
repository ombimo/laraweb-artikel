<?php

namespace Ombimo\LarawebArtikel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

class ArtikelLocale extends Model
{
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function locale()
    {
        $locale = App::getLocale();

        return $this->hasOne('Ombimo\LarawebArtikel\Models\ArtikelLocale')->where('locale', $locale);
    }

    public function getSinopsisAttribute()
    {
        if (empty($this->sinopsis)) {
            $sinopsis = Str::limit(strip_tags($this->isi), 200, '');
        } else {
            $sinopsis = $this->sinopsis;
        }

        return $sinopsis;
    }
}
