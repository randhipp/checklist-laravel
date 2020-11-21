<?php

namespace Database\Seeders;

use Symfony\Component\Console\Output\ConsoleOutput;
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
        $output = new ConsoleOutput();
        $output->writeln("<info>Creating 30 Checklists. Each checklist have 3 items.</info>");
        Checklist::factory(30)
                ->has(Item::factory(3))
                ->create();
        $output->writeln("done");

    }
}
