<?php

namespace App\Services\Follow;

use App\Interfaces\Follow\FollowRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class CountFollowService extends BaseService
{
    protected $followRepository;

    public function __construct(FollowRepositoryInterface $followRepository)
    {
        $this->followRepository = $followRepository;
    }

    public function handle()
    {
        try {
            return $this->followRepository->countFollow($this->data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
