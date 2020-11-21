<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Output\ConsoleOutput;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $output = new ConsoleOutput();
        $output->writeln("<info>Creating admin & dummy user...</info>");
        // Log::channel('stderr')->info("Creating admin user...");
        User::factory(1)->create([
            'name' => 'admin',
            'email' => 'admin@admin.com'
        ]);
        // Log::channel('stderr')->info("Admin created!");
        // Log::channel('stderr')->info("Creating 10 dummy user...");
        User::factory(1)->create();
        // Log::channel('stderr')->info("Users created!");
        // Log::channel('stderr')->info("Create Sanctum Token...");
        foreach(User::all() as $user){
            $token = $user->createToken('default-token');
            $output->writeln("User & Token created for $user->email -> $token->plainTextToken");

            // Log::channel('stderr')->info("Token created for $user->email -> $token->plainTextToken");
        }
    }
}
