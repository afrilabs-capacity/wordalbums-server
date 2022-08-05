<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information_pages', function (Blueprint $table) {
            $table->id();
            $table->integer('book_id');
            $table->longText('release_information')->nullable();
            $table->string('cover_photo')->nullable();
            $table->boolean('page_start')->nullable();
            $table->boolean('page_end')->nullable();
            $table->integer('position')->nullable();
            $table->integer('donation_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('information_pages');
    }
}
