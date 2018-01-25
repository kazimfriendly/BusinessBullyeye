<?php

use Illuminate\Database\Seeder;

class userRoles extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('roles')->insert(
        [
        'name' => 'Coaches',
        'desc' => 'Coaches use to offer modules to clients',
        ]
                
        );
        
        DB::table('roles')->insert(
        [
        'name' => 'Clients',
        'desc' => 'Clients by modules form coaches.',
        ]
                );
    }

}
