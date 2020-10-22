<?php

namespace Ombimo\LarawebArtikel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Ombimo\LarawebArtikel\Models\Artikel;
use Ombimo\LarawebArtikel\Models\ArtikelKategori;
use Ombimo\LarawebArtikel\Models\ArtikelTag;
use Ombimo\LarawebCore\Breadcrumb;
use Artesaos\SEOTools\Facades\SEOTools as SEO;
use Ombimo\LarawebCore\Helpers\Web;

class ArtikelIndexController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        $route = $request->route();
        $parameters = $route->parameters();
        $page = intval($request->query('page', 1));
        $query = Artikel::publish()->defaultSort();

        if (config('laraweb.multilang')) {
            $query = $query->with('locale');
        }

        $title = 'Blog';
        Breadcrumb::add(__('app.menu.blog'), route('artikel-index'));

        //jika ada parameter kategoriSlug
        if (isset($parameters['kategoriSlug'])) {
            $kategori = ArtikelKategori::where('slug', $parameters['kategoriSlug'])->firstOrFail();
            $query = $query->where('kategori_id', $kategori->id);
            $title = 'Tulisan dengan kategori ' . $kategori->nama;
        }

        //jika ada parameter tagSlug
        if (isset($parameters['tagSlug'])) {
            $tag = ArtikelTag::where('name', $parameters['tagSlug'])->firstOrFail();
            $query = $query->whereHas('tags', function ($query) use ($tag) {
                $query->where('tag_id', $tag->id);
            });
            $title = 'Tulisan dengan tag #' . $tag->name;
        }

        //jika halaman ke sekian
        if ($page > 1) {
            $title .= ' Halaman ke ' . $page;
        }

        $dataArtikel = $query->paginate(12);

        //set SEO
        SEO::setTitle($title);
        if (!empty($dataArtikel->previousPageUrl())) {
            SEO::metatags()->setPrev($dataArtikel->previousPageUrl());
        }
        if (!empty($dataArtikel->nextPageUrl())) {
            SEO::metatags()->setNext($dataArtikel->nextPageUrl());
        }

        $defaultImg = 'images/logo-og.png';
        SEO::opengraph()->addImage(asset($defaultImg), ['height' => 300, 'width' => 300]);
        SEO::twitter()->addImage(asset($defaultImg));

        Web::setMenu('artikel');

        return view('artikel.index', [
            'dataArtikel' => $dataArtikel,
            'title' => $title,
        ]);
    }
}
