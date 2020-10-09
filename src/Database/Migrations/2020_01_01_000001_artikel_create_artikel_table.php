<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArtikelCreateArtikelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();

            $table->foreignId('kategori_id')->nullable()
                  ->constrained('artikel_kategori')
                  ->onUpdate('no action')
                  ->onDelete('set null');

            $table->string('judul')->nullable();
            $table->string('slug')->nullable();
            $table->string('cover')->nullable();
            $table->text('sinopsis')->nullable();
            $table->mediumText('isi')->nullable();
            $table->boolean('publish')->default(true);
            $table->boolean('rekomendasi')->default(false);
            $table->timestamps();
            $table->unique(['user_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artikel');
    }
}
