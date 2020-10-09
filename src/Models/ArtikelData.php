<?php

namespace Ombimo\LarawebArtikel\Models;

use Illuminate\Database\Eloquent\Model;

class ArtikelData extends Model
{
    protected $table = 'artikel_data';

    protected $primaryKey = 'artikel_id';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = ['artikel_id'];

    public function artikel()
    {
        return $this->belongsTo('Ombimo\LarawebArtikel\Models\Artikel', 'artikel_id');
    }
}
