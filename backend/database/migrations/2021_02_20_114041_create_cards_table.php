<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration {
    public function up() {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();

            // Main staff
            $table->string('name', 100);
            $table->unsignedTinyInteger('location');
            $table->integer('index');
            $table->unsignedBigInteger('user_id');

            $table->string('color', 30)->default('#EBECF0'); // color grey
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down() {
        Schema::dropIfExists('cards');
    }
}
