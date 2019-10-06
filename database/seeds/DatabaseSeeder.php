<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    // public function run()
    // {
    //     // $this->call(UsersTableSeeder::class);

    // }
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
    	$admin = App\role::create([
            'name'=>'admin'
        ]);
        $users = App\role::create([
            'name'=>'user'
        ]);
        $notApproved = App\role::create([
            'name'=>'block'
        ]);
        factory(\App\User::class)->create();
    }
}
