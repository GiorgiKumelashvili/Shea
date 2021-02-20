<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration {
    public function up() {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->unsignedTinyInteger('location');
            $table->string('color', 30)->default('#EBECF0'); // color grey
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('cards');
    }
}
