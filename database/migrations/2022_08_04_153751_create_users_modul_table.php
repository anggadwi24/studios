<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersModulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_modul', function (Blueprint $table) {
            $table->increments('umod_id');
            $table->integer('umod_users_id');
            $table->integer('umod_modul_id');
            $table->integer('umod_submodul_id');

          

           $table->timestamp('umod_created_at')->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_modul');
    }
}
