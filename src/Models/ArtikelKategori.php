<?php

namespace Ombimo\LarawebArtikel\Models;

use Illuminate\Database\Eloquent\Model;

class ArtikelKategori extends Model
{
    protected $table = 'artikel_kategori';

    protected $fillable = ['user_id', 'nama'];

    public function artikel()
    {
        return $this->hasMany('Ombimo\LarawebArtikel\Models\Artikel', 'kategori_id');
    }

    public function getLinkAttribute()
    {
        return route('blog.kategori', [
            'tagSlug' => $this->slug
        ]);
    }
}
