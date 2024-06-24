<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Author\AuthorResource;
use App\Services\Api\Admin\Author\GetAuthorByAdminService;

class AdminAuthorController extends Controller
{
    public function getListAuthors()
    {
        $authors = resolve(GetAuthorByAdminService::class)->handle();

        if (!$authors) {
            return $this->responseErrors(__('author.get_failed'));
        }

        return $this->responseSuccess([
            'message' => __('author.get_success'),
            'data' => AuthorResource::collection($authors),
        ]);
    }
}
