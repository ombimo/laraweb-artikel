<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArtikelCreateArtikelHasTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artikel_has_tags', function (Blueprint $table) {
            $table->foreignId('artikel_id')
                  ->constrained('artikel')
                  ->onUpdate('no action')
                  ->onDelete('cascade');

            $table->foreignId('tag_id')
                  ->constrained('artikel_tags')
                  ->onUpdate('no action')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artikel_has_tags');
    }
}
