<?php

namespace Ombimo\LarawebArtikel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Ombimo\LarawebArtikel\Database\Factories\ArtikelFactory;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ArtikelFactory::new();
    }

    public function locale()
    {
        $locale = App::getLocale();

        return $this->hasOne('Ombimo\LarawebArtikel\Models\ArtikelLocale')->where('locale', $locale);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function kategori()
    {
        return $this->belongsTo('Ombimo\LarawebArtikel\Models\ArtikelKategori', 'kategori_id');
    }

    public function tags()
    {
        return $this->belongsToMany('Ombimo\LarawebArtikel\Models\ArtikelTag', 'artikel_has_tags', 'artikel_id', 'tag_id');
    }

    public function scopePublish($query)
    {
        return $query->where('publish', true);
    }

    public function scopeDefaultSort($query)
    {
        return $query->orderByDesc('created_at');
    }

    public function getLinkDetailAttribute()
    {
        $locale = App::getLocale();

        return route('artikel-detail', [
            'locale' => $locale,
            'id' => $this->id,
            'slug' => Str::slug($this->judul)
        ]);
    }

    public function getLinkDetailAmpAttribute()
    {
        return route('blog.detail.amp', [
            'id' => $this->id,
            'slug' => Str::slug($this->judul)
        ]);
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

    public function getLocaleJudulAttribute()
    {
        return $this->locale ? $this->locale->judul : $this->judul;
    }

    public function getLocaleIsiAttribute()
    {
        return $this->locale ? $this->locale->isi : $this->isi;
    }

    public function getLocaleSinopsisAttribute()
    {
        return $this->locale ? $this->locale->sinopsis : $this->sinopsis;
    }
}
