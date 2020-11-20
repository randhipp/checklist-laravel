<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
// use App\Pagination\CustomPaginatedResourceResponse;
use App\Helper\CustomJsonResource;
class Checklist extends CustomJsonResource
{
    // public $collection;

    // public function __construct($collection)
    // {
    //     $this->collection = $collection;
    // }

    // public function toResponse($request)
    // {
    //     // if ($this->resource instanceof AbstractPaginator) {
    //     //     return $this->preparePaginatedResponse($request);
    //     // }

    //     // return parent::toResponse($request);

    //     // return (new CustomPaginatedResourceResponse($this))->toResponse($request);
    // }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);

        // $data = [
        //     'type' => 'checklists',
        //     // 'id' => $this->collection->id,
        //     'attributes' => $this->resource,
        //     'links' => [
        //         // 'self' => url('/api/v1/checklists',$this->collection->id)
        //     ]
        // ];

        // return $data;
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
