<?php

namespace App\Services\Api\Genre;

use App\Interfaces\Genre\GenreRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class GetGenreService.
 */
class GetGenreService
{
    protected $genreRepository;

    public function __construct(GenreRepositoryInterface $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function handle()
    {
        try {
            return $this->genreRepository->all();
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
