<?php

namespace Ombimo\LarawebArtikel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Ombimo\LarawebArtikel\Models\Artikel;
use App\Helpers\Sitemap as SitemapHelper;

class Sitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lw-artikel:sitemap {--reset}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create sitemap artikel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Create Sitemap artikel Start');

        $reset = $this->option('reset');
        $dir = public_path() . DIRECTORY_SEPARATOR.'sitemap' . DIRECTORY_SEPARATOR . 'artikel';
        $date = \Carbon\Carbon::now()->format('Y-m');

        if (!file_exists($dir) && !is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        if (!$reset) {
            $this->createSitemap($dir, $date);
        } else {
            array_map('unlink', glob($dir. DIRECTORY_SEPARATOR . '*'));
            $this->info('reset sitemap');

            $dataDate = Artikel::publish()->select(DB::raw('DATE_FORMAT(created_at,"%Y-%m") as date'))
                                ->groupBy(DB::raw('DATE_FORMAT(created_at,"%Y-%m")'))->get();
            foreach ($dataDate as $date) {
                $this->info($date->date);
                $this->createSitemap($dir, $date->date);
            }
        }

        $this->info('Create Sitemap artikel Start');
    }

    private function createSitemap($dir, $date)
    {
        $sitemap = [];
        $dataEvent = Artikel::publish()->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$date])->get();
        foreach ($dataEvent as $value) {
            $this->info($value->link_detail);
            $sitemap[] = [
                "loc" => $value->link_detail,
                "lastmod" => optional($value->update_at)->format('Y-m-d')
            ];
        }
        if (!empty($sitemap)) {
            $filename = $dir. DIRECTORY_SEPARATOR. $date . '-artikel.xml';
            $this->info('writing sitemap ' . $filename);
            SitemapHelper::createFromArray($filename, $sitemap);
        }
    }
}
