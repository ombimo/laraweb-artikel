<?php

namespace Ombimo\LarawebArtikel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Ombimo\LarawebArtikel\Models\ArtikelTag;


class FixTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'md-artikel:fix-tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix Tags';

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
        ArtikelTag::chunk(200, function ($tags) {
            foreach ($tags as $tag) {
                $newName = str_replace('#', '', strtolower(trim($tag->name)));
                $newName = str_replace('@', '', $newName);
                $newName = str_replace(' ', '-', $newName);
                $this->info($tag->name. ' -> '.$newName);
                $tag->name = $newName;
                $tag->save();
            }
        });
    }
}
