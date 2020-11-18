<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;
use Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
