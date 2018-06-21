<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\User::create([
        //     'first_name' => 'Brian',
        //     'last_name' => 'Fox',
        //     'mobile' => null,
        //     'user_level' => 99,
        //     'email' => 'bfox@comcast.net',
        //     'password' => bcrypt('password'),
        //     'remember_token' => str_random(10),
        // ]); 

        factory(App\User::class, 100)->create();
    
    }
}
