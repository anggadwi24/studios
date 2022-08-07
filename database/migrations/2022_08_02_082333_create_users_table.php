<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('users_id');
            $table->string('users_name');
            $table->string('users_email')->unique();
            $table->enum('users_level', ['admin', 'user'])->default('user');
            $table->string('users_password');
            $table->string('users_photo');

            $table->enum('users_active',['y','n'])->default('y');

           $table->timestamp('users_created_at')->useCurrent();
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
