<?php

namespace App\Http\Controllers\Api\Genre;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Genre\CreateGenreRequest;
use App\Http\Requests\Api\Genre\UpdateGenreRequest;
use App\Services\Api\Genre\CreateGenreService;
use App\Services\Api\Genre\DeleteGenreService;
use App\Services\Api\Genre\GetGenreService;
use App\Services\Api\Genre\UpdateGenreService;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres = resolve(GetGenreService::class)->handle();

        if (!$genres) {
            return $this->responseErrors(__('messages.error_action', ['action' => 'display', 'attribute' => 'genres',]));
        }

        return $this->responseSuccess([
            'genres' => $genres,
            'message' => __('messages.success_action', ['action' => 'display', 'attribute' => 'genres',]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGenreRequest $request)
    {
        $genre = resolve(CreateGenreService::class)->setParams($request->validated())->handle();

        if (!$genre) {
            return $this->responseErrors(__('messages.error_action', ['action' => 'create', 'attribute' => 'genre',]));
        }

        return $this->responseSuccess([
            'genre' => $genre,
            'message' => __('messages.success_action', ['action' => 'create', 'attribute' => 'genre',]),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGenreRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $genre = resolve(UpdateGenreService::class)->setParams($data)->handle();

        if (!$genre) {
            return $this->responseErrors(__('messages.error_action', ['action' => 'update', 'attribute' => 'genre',]));
        }

        return $this->responseSuccess([
            'genre' => $genre,
            'message' => __('messages.success_action', ['action' => 'update', 'attribute' => 'genre',]),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['id'] = $id;
        $genre = resolve(DeleteGenreService::class)->setParams($data)->handle();

        if (!$genre) {
            return $this->responseErrors(__('messages.error_action', ['action' => 'delete', 'attribute' => 'genre',]));
        }

        return $this->responseSuccess([
            'message' => __('messages.success_action', ['action' => 'delete', 'attribute' => 'genre',]),
        ]);
    }
}
