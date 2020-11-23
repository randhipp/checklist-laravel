<?php

namespace Tests\Unit;

use Helmich\JsonAssert\JsonAssertions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Checklist;
use App\Models\Items;

use Laravel\Sanctum\Sanctum;
class ItemsIncompleteTest extends TestCase
{
    use JsonAssertions;

    /**
     * Testing Get With no Auth Token
     *
     * @return void
     */
    public function testGetNoAuth()
    {
        $response = $this->json('POST','/api/v1/checklists/incomplete',
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
    public function testGetWrongBody()
    {
        Sanctum::actingAs(
            User::find(1),
            ['login']
        );

        $response = $this->json('POST','/api/v1/checklists/incomplete',
       [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
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

        $jsonDocument = app_path('storage/json-schema/items','incomplete.json');

        $response = $this->json('POST','/api/v1/checklists/incomplete',
        [
            'data' => [
                '0' => [
                    'item_id' => 1
                ],
                '1' => [
                    'item_id' => 2
                ]
            ]
        ],[
            'Accept' => 'application/json',
        ]);

        $this->assertJsonDocumentMatchesSchema($jsonDocument, $response->getContent());
     }
}
