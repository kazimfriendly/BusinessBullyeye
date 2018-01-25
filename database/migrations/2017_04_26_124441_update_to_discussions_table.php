<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateToDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discussions', function($table) {
            
            $table->tinyInteger('visibility')->comment('* status field can hold
             * 1 for client only
             * 0 for all
             ')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        chema::table('discussions', function($table) {
          $table->dropColumn('visibility');
          });
    }
}
