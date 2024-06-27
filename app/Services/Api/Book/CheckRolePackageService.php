<?php

namespace App\Services\Api\Book;

use App\Enums\PackageType;
use App\Interfaces\Book\BookRepositoryInterface;
use App\Models\ServicePackage;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

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
            $packageType = $book->package_type;

            $status = false;

            if ($packageType == PackageType::FREE ||
                ($packageType == PackageType::BASE && in_array($type, [PackageType::BASE, PackageType::PREMIUM])) ||
                ($packageType == PackageType::PREMIUM && $type == PackageType::PREMIUM)) {
                $status = true;
            }

            return response()->json([
                'data' => $book,
                'status' => $status
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::info($e);

            return response()->json([
                'message' => __('common.error_server'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
