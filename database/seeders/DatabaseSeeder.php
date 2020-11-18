<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Log::channel('stderr')->info("Creating 10 dummy user...");
        User::factory(10)->create();
        foreach(User::all() as $user){
            $token = $user->createToken('default-token');
            Log::channel('stderr')->info("Token created for $user->email -> $token->plainTextToken");
        }
        Log::channel('stderr')->info("User created!");
    }
}
