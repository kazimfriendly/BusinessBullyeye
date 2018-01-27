<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateToModulesStructure extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('modules', function($table) {
            $table->boolean("is_live")->default(false);
            $table->boolean("status")->default(true);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('modules', function($table) {
        $table->dropColumn('is_live');
        $table->dropColumn('status');
    });
    }

}
