<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateToPackageModuleTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('package_module', function (Blueprint $table) {
            $table->renameColumn('parent_id', 'order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('uspackage_moduleers', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }

}
