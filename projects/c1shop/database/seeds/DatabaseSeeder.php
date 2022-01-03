<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(FiltersPerfomanceTableSeeder::class);
        //$this->call(WidthFiltersTableSeeder::class);
        $this->call(ActionFiltersTableSeeder::class);
    }
}
