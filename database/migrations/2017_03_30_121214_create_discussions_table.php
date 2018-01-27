<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('user_response_question', 'discussions');
        Schema::table('discussions', function($table) {
            $table->integer("assignment_id")->unsigned()->index();
            $table->foreign("assignment_id")->references('id')->on('assignments')->onDelete('cascade');
            /**
             * status filed can hold
             * 1 for active module
             * 2 for in progress module
             * 3 for in pending module  
             * 4 for completion of module
             *  */
             $table->increments('id')->first();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discussions');
    }
}
