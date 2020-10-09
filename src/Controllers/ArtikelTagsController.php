<?php

namespace Ombimo\LarawebArtikel\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ombimo\LarawebArtikel\Models\ArtikelTag;
use Spatie\SchemaOrg\Schema;
use SEO;
use OpenGraph;
use Twitter;

class ArtikelTagsController extends Controller
{
    public function index()
    {
        $dataTags = ArtikelTag::withCount('artikel')->orderBy('name')->get();

        //breadcrumb
        $schemaBreadcrumb = Schema::BreadcrumbList()->itemListElement([
            Schema::listItem()
                ->name('Blog')
                ->item(route('blog.index'))
                ->position(1),

            Schema::listItem()
                ->name('Tags')
                ->item(route('blog.tags.index'))
                ->position(2)
        ]);

        //SEO
        $defaultImg = 'images/logo-og.png';

        SEO::setTitle('Daftar Tag');
        OpenGraph::addImage(asset($defaultImg), ['height' => 300, 'width' => 300]);
        Twitter::addImage(asset($defaultImg));

        return view('moduleArtikel::tags-index', [
            'schemaBreadcrumb' => $schemaBreadcrumb,
            'dataTags' => $dataTags
        ]);
    }
}
