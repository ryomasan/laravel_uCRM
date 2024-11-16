<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'name' => Str::random(10),
            'memo' => Str::random(30),
            'price' => random_int(100, 999) * 10, // Generate 4-digit number ending with 0
            'is_selling' => (bool)random_int(0, 1) // Randomly true or false
        ]);
    }
}
