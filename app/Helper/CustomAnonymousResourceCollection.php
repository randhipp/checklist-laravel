<?php
namespace App\Helper;

use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CustomAnonymousResourceCollection extends AnonymousResourceCollection
{
    public function toResponse($request)
    {
        return $this->resource instanceof AbstractPaginator
                    ? (new CustomPaginatedResourceResponse($this))->toResponse($request)
                    : parent::toResponse($request);
    }
}
