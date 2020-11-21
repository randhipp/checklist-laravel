<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

use Log;

class AuthenticationTest extends TestCase
{
    /**
     * No Token in Auth Bearer.
     *
     * @return void
     */
    public function testNoToken()
    {
        $this->json('GET', 'api/v1/user', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "status" => "401",
                "error" => "Not Authorized"
            ]);
    }

    /**
    * Wrong Token in Auth Bearer.
    *
    * @return void
    */
    public function testWrongToken()
    {
        $this->json('GET', 'api/v1/user', [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer random123'
        ])
            ->assertStatus(401)
            ->assertJson([
                "status" => "401",
                "error" => "Not Authorized"
            ]);
    }

    /**
    * Auth Successfully.
    *
    * @return void
    */
    public function testCorrectToken()
    {
        Sanctum::actingAs(
            User::find(1),
            ['login']
        );

        $response = $this->get('/api/v1/user');

        $response->assertOk();

    }
}
