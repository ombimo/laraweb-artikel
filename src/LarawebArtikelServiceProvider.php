<?php

namespace Ombimo\LarawebArtikel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Ombimo\LarawebArtikel\Models\Artikel;
use Ombimo\LarawebArtikel\Models\ArtikelKategori;
use Ombimo\LarawebArtikel\Models\ArtikelTag;

class LarawebArtikelServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        //route
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        //migration
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        if (config('laraweb.multilang')) {
            $this->loadMigrationsFrom(__DIR__.'/Database/MigrationsMulti');
        }

        //$this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/Database/factories');

        $this->commands([
            Commands\FixTags::class,
            Commands\Sitemap::class,
        ]);

        $this->publishes([
            __DIR__ . '/../resources/view' => resource_path('views'),
            __DIR__ . '/../config/laraweb.php' => config_path('laraweb-artikel.php'),
        ]);

        View::composer('artikel.widget.kategori-*', function ($view) {
            $dataKategori = ArtikelKategori::withCount('artikel')->take(10)->get();
            $view->with('widgetArtikelKategori', $dataKategori);
        });

        View::composer('artikel.widget.tags-*', function ($view) {
            $dataTags = ArtikelTag::withCount('artikel')->has('artikel', '>', 0)->inRandomOrder()->limit(20)->get();
            $view->with('widgetArtikelTags', $dataTags);
        });

        View::composer('artikel.widget.artikel-terbaru-*', function ($view) {
            $data = Artikel::publish()->latest()->limit(3)->get();
            $view->with('widgetArtikelTerbaru', $data);
        });
    }
}
