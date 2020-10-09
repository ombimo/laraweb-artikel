<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArtikelCreateArtikelLocaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artikel_locales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('artikel_id')->nullable()
                  ->constrained('artikel')
                  ->onUpdate('no action')
                  ->onDelete('cascade');

            $table->string('locale', 5)->index();

            $table->string('judul')->nullable();
            $table->string('slug')->nullable();
            $table->string('cover')->nullable();
            $table->text('sinopsis')->nullable();
            $table->mediumText('isi')->nullable();
            $table->timestamps();
            $table->unique(['artikel_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artikel_locales');
    }
}
