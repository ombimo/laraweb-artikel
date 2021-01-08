<?php

namespace Ombimo\LarawebArtikel\Models;

use Illuminate\Database\Eloquent\Model;

class ArtikelTag extends Model
{
    protected $table = 'artikel_tags';

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name'];

    public function artikel()
    {
        return $this->belongsToMany('Ombimo\LarawebArtikel\Models\Artikel', 'artikel_has_tags', 'tag_id', 'artikel_id');
    }

    public function getLinkAttribute()
    {
        return route('artikel-index.by-tag', [
            'tagSlug' => $this->name
        ]);
    }
}
