<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
  
    public function run()
    {
        //Aqui enlistar mas seeders
        $this->call(UserSeeder::class);
    }
}
