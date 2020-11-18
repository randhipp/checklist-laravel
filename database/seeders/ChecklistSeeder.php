<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Checklist;
use App\Models\Item;

class ChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Checklist::factory(100)
                ->has(Item::factory(5))
                ->create();

    }
}
