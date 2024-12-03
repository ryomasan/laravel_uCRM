<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemPurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = Item::all();
        Purchase::factory(100)->create()->each(
            function (Purchase $purchase) use ($items) {
                $purchase->items()->attach(
                    $items->random(rand(1, 5))->pluck('id')->toArray(),
                    ['quantity' => rand(1, 5)]
                );
            }
        );
    }
}
