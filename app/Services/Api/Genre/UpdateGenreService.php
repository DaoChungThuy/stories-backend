<?php

namespace App\Services\Api\Genre;

use App\Interfaces\Genre\GenreRepositoryInterface;
use App\Services\BaseService;
use App\Traits\UploadFileTrait;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class UpdateGenreService.
 */
class UpdateGenreService extends BaseService
{
    use UploadFileTrait;

    protected $genreRepository;

    public function __construct(GenreRepositoryInterface $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function handle()
    {
        try {
            if (isset($this->data['cover_image']) && $this->data['cover_image']->isValid()) {
                $this->data['cover_image'] = $this->uploadFile($this->data['cover_image'], 'genre_cover');
            }

            return $this->genreRepository->update($this->data, $this->data['id']);
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
