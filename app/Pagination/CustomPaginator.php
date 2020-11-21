<?php

namespace App\Pagination;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomPaginator extends LengthAwarePaginator
{
    /**
     * Get the instance as an array.
     *
     * This can be structured however you want and overrides
     * the function in LengthAwarePaginator.
     *
     * @return array
     */
    public function toArray()
    {
        $data = $this->items;

        $domain = \explode('.',request()->route()->getName())[0];

        $data->transform(function ($item, $key) use ($domain) {

            $newFormat = [
                'type' => $domain,
                'id' => $item->id,
                'attributes' => $item,
                'links' => [
                    'self' => url('api/v1/'.$domain, $item->id)
                ]
            ] ;


            return $newFormat;
        });

        return [
            'data' => $data->toArray(),
            'meta' => [
                'count' => $this->perPage()*$this->currentPage(),
                'total' => $this->total(),
                // 'pagination' => [
                //     'current_page' => $this->currentPage(),
                //     'first_page_url' => $this->url(1),
                //     'from' => $this->firstItem(),
                //     'last_page' => $this->lastPage(),
                //     'last_page_url' => $this->url($this->lastPage()),
                //     'next_page_url' => $this->nextPageUrl(),
                //     'path' => $this->path(),
                //     'per_page' => $this->perPage(),
                //     'prev_page_url' => $this->previousPageUrl(),

                // ],
            ],
            'links' => [
                'first' => $this->url(1) ?? null,
                'last' => $this->url($this->lastPage()) ?? null,
                'prev' => $this->previousPageUrl() ?? null,
                'next' => $this->nextPageUrl() ?? null,
            ],
        ];
    }
}
