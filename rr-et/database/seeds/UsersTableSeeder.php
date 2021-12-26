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
        factory(App\User::class, 20)->create();
        
        $user = new \App\User([
            'name' => 'foobar',
            'role' => 1,
            'email' => 'foo@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->save();
    }
}
