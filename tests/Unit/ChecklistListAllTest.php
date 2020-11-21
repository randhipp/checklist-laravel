<?php

namespace Tests\Unit;

use Helmich\JsonAssert\JsonAssertions;
use Symfony\Component\Console\Output\ConsoleOutput;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Checklist;

use Laravel\Sanctum\Sanctum;

class ChecklistListAllTest extends TestCase
{
    use JsonAssertions;

    /**
     * Testing GetAll With no Auth Token
     *
     * @return void
     */
    public function testGetAllNoAuth()
    {
        $response = $this->json('GET','/api/v1/checklists',
        [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

    /**
     * Testing GetAll Validation - Correct Value
     *
     * @return void
     */
     public function testGetAllSuccessWithMatchedJsonSchema()
     {
        Sanctum::actingAs(
             User::find(1),
             ['login']
        );

        $jsonDocument = app_path('storage/json-schema/checklists','list-all.json');

        $response = $this->json('GET','/api/v1/checklists',
         [
             'Accept' => 'application/json',
         ]);

        $this->assertJsonDocumentMatchesSchema($jsonDocument, $response->getContent());

     }
}
