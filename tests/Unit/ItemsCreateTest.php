<?php

namespace Tests\Unit;

use Helmich\JsonAssert\JsonAssertions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

use Laravel\Sanctum\Sanctum;

class ItemsCreateTest extends TestCase
{
    use JsonAssertions;
    /**
     * Testing Create With no Auth Token
     *
     * @return void
     */
    public function testCreateWithNoAuth()
    {
        $response = $this->json('POST','/api/v1/checklists/1/items',
        [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

     /**
     * Testing Create Validation - Wrong Value
     *
     * @return void
     */
    public function testCreateValidationWrongValue()
    {
        Sanctum::actingAs(
            User::find(1),
            ['login']
        );

        $response = $this->json('POST','/api/v1/checklists/1/items',
        [
            'data' => [
                'attributes' => [
                    'description' => '',
                    'object_id' => '',
                    'object_domain' => ''
                ]
            ]
        ],[
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
    }

    /**
     * Testing Create Validation - Correct Value
     *
     * @return void
     */
     public function testCreateSuccessWithMatchedJsonSchema()
     {
         Sanctum::actingAs(
             User::find(1),
             ['login']
         );

         $response = $this->json('POST','/api/v1/checklists/1/items',
         [
            'data' => [
                'attributes' => [
                    'description' => 'Verify this house'
                ]
            ]
         ],[
             'Accept' => 'application/json',
         ]);

        $jsonDocument = app_path('storage/json-schema/items','one.json');

        $this->assertJsonDocumentMatchesSchema($jsonDocument, $response->getContent());

    }
}
