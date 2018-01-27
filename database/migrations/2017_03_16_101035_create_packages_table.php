<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            
            $table->float('price', 8, 2)->nullable();
            $table->char('currency', 4)->nullable();
            $table->enum('paymnent_frequency', ['One Off', 'monthly', 'weekly', 'yearly'])->nullable();
            $table->string('facebook_group')->nullable();
            $table->enum('release_schedule', ['deliver immediately', 'rolling launch', 'one off launch', 'on completion of previous'])->nullable();
            
            $table->timestamps();
        });
        
         Schema::create('package_module',function (Blueprint $table) {
            $table->integer("module_id")->unsigned()->index();
            $table->foreign("module_id")->references('id')->on('modules')->onDelete('cascade');
            $table->integer("package_id")->unsigned()->index();
            $table->foreign("package_id")->references('id')->on('packages')->onDelete('cascade');
            $table->integer('parent_id')->default(0);
            
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
        Schema::drop("packages");
        Schema::drop("package_module");
    }
}
