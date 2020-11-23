<?php

namespace Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Checklist;

use Laravel\Sanctum\Sanctum;

class ItemsDeleteTest extends TestCase
{
    /**
     * Testing Delete With no Auth Token
     *
     * @return void
     */
    public function testDeleteWithNoAuth()
    {
        $response = $this->json('DELETE','/api/v1/checklists/2/items/4',
        [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

     /**
     * Testing Delete Validation - Wrong Value
     *
     * @return void
     */
    public function testDeleteWrongId()
    {
        Sanctum::actingAs(
            User::find(1),
            ['login']
        );

        $response = $this->json('DELETE','/api/v1/checklists/999',
       [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(404);
    }

    /**
     * Testing Delete Validation - Correct Value
     *
     * @return void
     */
     public function testDeleteSuccess()
     {
        Sanctum::actingAs(
             User::find(1),
             ['login']
        );

        $response = $this->json('DELETE','/api/v1/checklists/2/items/4',
         [
             'Accept' => 'application/json',
         ]);

        $response->assertStatus(200);
     }

     /**
     * Testing Delete Validation - Correct Value
     *
     * @return void
     */
    public function testDeleteOnRecentlyDeleted()
    {
       Sanctum::actingAs(
            User::find(1),
            ['login']
       );

       $response = $this->json('DELETE','/api/v1/checklists/2/items/4',
        [
            'Accept' => 'application/json',
        ]);

       $response->assertStatus(404);
    }
}
