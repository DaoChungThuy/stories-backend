<?php

namespace App\Services\Api\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Services\BaseService;
use App\Traits\UploadFileImageTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateBookService extends BaseService
{
    use UploadFileImageTrait;
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle()
    {
        try {
            if (!empty($this->data['cover_image'])) {
                $this->data['cover_image'] = $this->uploadFileImage($this->data['cover_image'], 'cover_image_story');
            }

            $book =  $this->bookRepository->update($this->data, $this->data['id']);

            return $book;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
