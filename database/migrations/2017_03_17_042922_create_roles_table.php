<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('desc');
            $table->timestamps();
        });
        
        Schema::create('role_user_package', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("role_id")->unsigned()->index();
            $table->foreign("role_id")->references('id')->on('roles')->onDelete('cascade');
            $table->integer("user_id")->unsigned()->index();
            $table->foreign("user_id")->references('id')->on('users')->onDelete('cascade');
            $table->integer("package_id")->unsigned()->index();
            $table->foreign("package_id")->references('id')->on('packages')->onDelete('cascade');
          
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
        Schema::drop('roles');
         Schema::drop('role_user');
        
    }
}
