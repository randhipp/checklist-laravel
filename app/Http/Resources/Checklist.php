<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Checklist extends ResourceCollection
{
    public $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    public function toResponse($request)
    {
        $data = $this->collection;
        // if ($data instanceof Collection) {
            $data = [
                'type' => 'checklists',
                'id' => $data->id,
                'attributes' => $data,
                'links' => [
                    'self' => url('/api/v1/checklists',$data->id)
                ]
            ];
        // }

        $paginated = $this->resource->toArray();
        // perform a dd($paginated) to see how $paginated looks like

        $json = array_merge_recursive(
            [
                self::$wrap => $data
            ],
            [
                'links' => [
                    'first' => $paginated['first_page_url'] ?? null,
                    'last' => $paginated['last_page_url'] ?? null,
                    'prev' => $paginated['prev_page_url'] ?? null,
                    'next' => $paginated['next_page_url'] ?? null,
                ],
                'meta' => [
                    'count' => $metaData['count'] ?? null,
                    'total' => $metaData['total'] ?? null,
                    // 'per_page' => $metaData['per_page'] ?? null,
                    // 'total_pages' => $metaData['total'] ?? null,
                ],
            ],
            $this->with($request),
            $this->additional
        );

        $status = $this->resource instanceof Model && $this->resource->wasRecentlyCreated ? 201 : 200;

        return response()->json($json, $status);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $data = [
            'type' => 'checklists',
            'id' => $this->collection->id,
            'attributes' => $this->collection,
            'links' => [
                'self' => url('/api/v1/checklists',$this->collection->id)
            ]
        ];

        return $data;
        // return [
        //     'type' => 'checklists',
        //     'id' => $this->collection->id,
        //     'attributes' => $this->collection,
        //     'links' => [
        //         'self' => url('/api/v1/checklists',$this->collection->id)
        //     ]
        // ];
    }
}
