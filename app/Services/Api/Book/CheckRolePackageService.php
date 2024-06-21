<?php

namespace App\Services\Api\Book;

use App\Enums\PackageType;
use App\Interfaces\Book\BookRepositoryInterface;
use App\Models\ServicePackage;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class CheckRolePackageService extends BaseService
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle()
    {
        try {
            $book = $this->bookRepository->getBookByChapterId($this->data['chapter_id']);
            $type = $this->data['type'];

            if ($book->package_type == PackageType::FREE) return true;

            if ($book->package_type == PackageType::BASE && in_array($type, [PackageType::BASE, PackageType::PREMIUM])) return true;

            if ($book->package_type == PackageType::PREMIUM && $type == PackageType::PREMIUM) return true;

            return false;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
