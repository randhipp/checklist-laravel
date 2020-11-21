<?php

namespace Tests\Unit;

use Helmich\JsonAssert\JsonAssertions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Checklist;

use Laravel\Sanctum\Sanctum;


class ChecklistGetOneTest extends TestCase
{
    use JsonAssertions;

    /**
     * Testing Get With no Auth Token
     *
     * @return void
     */
    public function testGetNoAuth()
    {
        $response = $this->json('GET','/api/v1/checklists/2',
        [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

     /**
     * Testing Get Validation - Wrong Value
     *
     * @return void
     */
    public function testGetWrongId()
    {
        Sanctum::actingAs(
            User::find(1),
            ['login']
        );

        $response = $this->json('GET','/api/v1/checklists/999',
       [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(404);
    }

    /**
     * Testing Get Validation - Correct Value
     *
     * @return void
     */
     public function testGetSuccess()
     {
        Sanctum::actingAs(
             User::find(1),
             ['login']
        );

        $jsonDocument = app_path('storage/json-schema/checklists','one.json');

        $response = $this->json('GET','/api/v1/checklists/2',
        [
            'Accept' => 'application/json',
        ]);

        $this->assertJsonDocumentMatchesSchema($jsonDocument, $response->getContent());
     }

}
