<?php

namespace App\Helper;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Support\Arr;

class CustomPaginatedResourceResponse extends PaginatedResourceResponse
{
    public function toResponse($request)
    {
        return tap(response()->json(
            $this->wrap(
                $this->resource->resolve($request),
                array_merge_recursive(
                    $this->paginationInformation($request),
                    $this->resource->with($request),
                    $this->resource->additional
                )
            ),
            $this->calculateStatus()
        ), function ($response) use ($request) {
            $this->resource->withResponse($request, $response);
        });
    }

    protected function paginationLinks($paginated)
    {
        return [
            'first' => $paginated['first_page_url'] ?? null,
            'last' => $paginated['last_page_url'] ?? null,
            'prev' => $paginated['prev_page_url'] ?? null,
            'next' => $paginated['next_page_url'] ?? null,
            ];
    }

    protected function meta($paginated)
    {
        $meta = Arr::except($paginated, [
            'data',
            'last_page_url',
            'prev_page_url',
            'next_page_url',
        ]);
        // $meta['pagination']['total_pages'] = $paginated['last_page'];

        return $meta;
    }
}
