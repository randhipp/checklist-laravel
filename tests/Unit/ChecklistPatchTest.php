<?php

namespace Tests\Unit;

use Symfony\Component\Console\Output\ConsoleOutput;
use Helmich\JsonAssert\JsonAssertions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Checklist;

use Laravel\Sanctum\Sanctum;

class ChecklistPatchTest extends TestCase
{
    use JsonAssertions;
    /**
     * Testing auth
     *
     * @return void
     */
    public function testPatchNoAuth()
    {
        $response = $this->json('PATCH','/api/v1/checklists/1',
            [
                'Accept' => 'application/json',
            ]);

        $response->assertStatus(401);
    }

    /**
     * Testing auth
     *
     * @return void
     */
    public function testPatchSuccessWithMatchedJsonSchema()
    {
        $response = $this->json('PATCH','/api/v1/checklists/1',
            [
                'data' => [
                    'attributes' => [
                        'description' => 'Verify this house',
                        'object_id' => '123',
                        'object_domain' => 'contact'
                    ]
                ]
            ],[
                'Accept' => 'application/json',
            ]);

        $jsonDocument = app_path('storage/json-schema/checklists','one.json');

        $this->assertJsonDocumentMatchesSchema($jsonDocument, $response->getContent());
    }
}
