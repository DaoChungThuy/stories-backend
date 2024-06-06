<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Customize the pagination information for API responses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param int|null $maxPageSize
     * @return array
     */
    public static function apiPaginate($query, $request, $maxPageSize = null)
    {
        $pageSize = $maxPageSize ?? config('common.pagination.page_size');

        if (($pageSizeInput = (int) $request->page_size) > 0) {
            $pageSize = min($pageSizeInput, config('common.pagination.max_page_size'));
        }

        return static::collection($query->paginate($pageSize)->appends($request->query()))
            ->response()
            ->getData();
    }
}
