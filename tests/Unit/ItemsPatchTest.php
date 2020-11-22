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

class ItemsPatchTest extends TestCase
{
    use JsonAssertions;
    /**
     * Testing auth
     *
     * @return void
     */
    public function testPatchNoAuth()
    {
        $response = $this->json('PATCH','/api/v1/checklists/2/items/4',
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
        $response = $this->json('PATCH','/api/v1/checklists/2/items/4',
            [
                'data' => [
                    'attribute' => [
                        'description' => 'Verify this house',
                        'due' => '2019-01-19 18:34:51',
                        'urgency' => '2',
                        'assignee_id' => 123
                    ]
                ]
            ],[
                'Accept' => 'application/json',
            ]);

        $jsonDocument = app_path('storage/json-schema/checklists','create-patch.json');

        $this->assertJsonDocumentMatchesSchema($jsonDocument, $response->getContent());
    }
}
