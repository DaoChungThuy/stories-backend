<?php

namespace App\Services\Api\Genre;

use App\Interfaces\Genre\GenreRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class DeleteGenreService.
 */
class DeleteGenreService extends BaseService
{
    protected $genreRepository;

    public function __construct(GenreRepositoryInterface $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function handle()
    {
        try {
            return $this->genreRepository->delete($this->data['id']);
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
