<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmodulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submoduls', function (Blueprint $table) {
            $table->increments('submodul_id');
            $table->integer('submodul_modul_id');
            $table->string('submodul_name');
            $table->string('submodul_slug');
            $table->enum('submodul_publish',['y','n'])->default('n');
            $table->timestamp('submodul_created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submoduls');
    }
}
