<?php

namespace App\Http\Controllers\Api\Admin\GenreManagement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Genre\GenreResource;
use App\Services\Api\Genre\GetGenreService;

class AdminGenreController extends Controller
{
    public function index()
    {
        $genres = resolve(GetGenreService::class)->handle();

        if (!$genres) {
            return $this->responseErrors(__('book.create_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('book.create_success'),
            'data' => GenreResource::collection($genres),
        ]);
    }
}
