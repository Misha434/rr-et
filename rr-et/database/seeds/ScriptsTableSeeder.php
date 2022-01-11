<?php

use Illuminate\Database\Seeder;

class ScriptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Script::class, 160)->create();
    }
}
