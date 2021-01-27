<?php

namespace Ombimo\LarawebArtikel\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ombimo\LarawebArtikel\Models\Artikel;
use Ombimo\LarawebArtikel\Models\ArtikelKategori;
use Ombimo\LarawebArtikel\Models\ArtikelTag;
use Illuminate\Support\Facades\Storage;
use Ombimo\LarawebCore\Helpers\Breadcrumb;
use Artesaos\SEOTools\Facades\SEOTools as SEO;

class ArtikelController extends Controller
{
    public function get(Request $request)
    {
        $params = $request->route()->parameters;

        $id = $params['id'] ?? null;

        $artikel = Artikel::with(['kategori', 'tags'])->findOrFail($id);

        //breadcrumb
        Breadcrumb::add(__('app.menu.blog'), route('artikel-index'));
        Breadcrumb::add($artikel->judul, $artikel->link_detail);

        //SEO
        $defaultImg = 'images/logo-og.png';

        SEO::setTitle($artikel->judul);
        SEO::setDescription($artikel->sinopsis);
        SEO::setCanonical($artikel->link_detail);
        SEO::twitter()->setType('summary_large_image');
        //SEO::metatags()->setAmpHtml($artikel->link_detail_amp);
        SEO::opengraph()->setUrl($artikel->link_detail);
        if( Storage::disk('public')->exists($artikel->cover)) {
            $dim = get_dimension($artikel->cover);
            $publicPath = asset(Storage::disk('public')->url($artikel->cover));

            SEO::opengraph()->addImage($publicPath, ['height' => $dim['height'], 'width' => $dim['width']]);
            SEO::twitter()->addImage($publicPath);
        } else {
            //default img
            SEO::opengraph()->addImage(asset($defaultImg), ['height' => 300, 'width' => 300]);
            SEO::twitter()->addImage(asset($defaultImg));
        }

        return view('artikel.detail', [
            'menu' => 'blog',
            'artikel' => $artikel,
        ]);
    }
}
