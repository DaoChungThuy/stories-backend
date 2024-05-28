<?php

namespace App\Http\Controllers\Api\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Author\CreateAuthorRequest;
use App\Services\Api\Author\CreateAuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function store(CreateAuthorRequest $request)
    {
        $author = resolve(CreateAuthorService::class)->setParams($request->all())->handle();

        if (!$author) {
            return $this->responseErrors(__('author.register_failed'));
        }

        return $this->responseSuccess([
            'message' => __('author.register_success'),
            'data' => $author,
        ]);
    }
}
