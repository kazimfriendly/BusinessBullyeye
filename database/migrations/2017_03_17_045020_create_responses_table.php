<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
                       
            $table->timestamps();
        });
        
         Schema::create('user_response_question',function (Blueprint $table) {
            $table->integer("user_id")->unsigned()->index();
            $table->foreign("user_id")->references('id')->on('users')->onDelete('cascade');
            $table->integer("question_id")->unsigned()->index();
            $table->foreign("question_id")->references('id')->on('questions')->onDelete('cascade');
            $table->integer("response_id")->unsigned()->index();
            $table->foreign("response_id")->references('id')->on('responses')->onDelete('cascade');
            
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
        Schema::drop("responses");
        Schema::drop("user_response_question");
    }
}
