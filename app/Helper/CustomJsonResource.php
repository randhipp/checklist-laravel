<?php
namespace App\Helper;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helper\CustomAnonymousResourceCollection;

class CustomJsonResource extends JsonResource
{
    public function toResponse($request)
    {
        return $this->resource instanceof AbstractPaginator
                    ? (new CustomPaginatedResourceResponse($this))->toResponse($request)
                    : parent::toResponse($request);
    }

    public static function collection($resource)
    {
        return tap(new CustomAnonymousResourceCollection($resource, static::class), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }
}
