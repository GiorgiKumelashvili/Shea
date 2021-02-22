<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration {

    public function up() {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->unsignedBigInteger('card_id');
            $table->string('color', 30)->default('#FFFFFF'); // color white
            $table->longText('description')->nullable();
            $table->string('url', 100);
            $table->integer('index');
            $table->timestamps();

            $table->foreign('card_id')->references('id')->on('cards');
        });
    }

    public function down() {
        Schema::dropIfExists('items');
    }
}
