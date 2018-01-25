<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     * 

     */
    public function up() {
        Schema::rename('role_user_package', 'assignments');
        Schema::table('assignments', function($table) {
            $table->integer("module_id")->unsigned()->index();
            $table->foreign("module_id")->references('id')->on('modules')->onDelete('cascade');
            /**
             * status filed can hold
             * 1 for active module
             * 2 for in progress module
             * 3 for in pending module
             * 4 for completion of module
             *  */
            $table->tinyInteger('status')->comment('* status field can hold
             * 1 for active module
             * 2 for in progress module
             * 3 for in pending module
             * 4 for completion of module
             ')->default(3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('assignments');
    }

}
