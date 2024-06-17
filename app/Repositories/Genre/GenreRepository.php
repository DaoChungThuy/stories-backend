<?php

namespace App\Repositories\Genre;

use App\Interfaces\Genre\GenreRepositoryInterface;
use App\Models\Genre;
use App\Repositories\BaseRepository;

class GenreRepository extends BaseRepository implements GenreRepositoryInterface
{
    public function __construct(Genre $genre)
    {
        $this->model = $genre;
    }
}
