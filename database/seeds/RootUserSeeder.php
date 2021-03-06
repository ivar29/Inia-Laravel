<?php

use Illuminate\Database\Seeder;
use App\User;

class RootUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' => 'USUARIO ROOT',
	        'email' => '1@asd.cl',
	        'password' => '1',
	        'cargo' => 'cargoROOT',
	        'cri' => 'CRIROOT',
	        //'remember_token' => str_random(10),
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);

    }
}
