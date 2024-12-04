<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Purchase;
use Illuminate\Database\Seeder;
use Database\Seeders\ItemSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ItemPurchaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ItemSeeder::class,
            // PurchaseSeeder::class,
            CustomerSeeder::class,
            ItemPurchaseSeeder::class,
            PurchaseSeeder::class
        ]);
    }
}
