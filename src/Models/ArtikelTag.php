<?php

namespace Ombimo\LarawebArtikel\Models;

use Illuminate\Database\Eloquent\Model;

class ArtikelTag extends Model
{
    protected $table = 'artikel_tags';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = ['nama'];

    public function artikel()
    {
        return $this->belongsToMany('Ombimo\LarawebArtikel\Models\Artikel', 'artikel_has_tags', 'tag_id', 'artikel_id');
    }

    public function getLinkAttribute()
    {
        return route('artikel-index.by-tag', [
            'tagSlug' => $this->nama
        ]);
    }
}
