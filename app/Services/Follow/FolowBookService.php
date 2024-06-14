<?php

namespace App\Services\Follow;

use App\Interfaces\Follow\FollowRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class FolowBookService extends BaseService
{
    protected $followRepository;

    public function __construct(FollowRepositoryInterface $followRepository)
    {
        $this->followRepository = $followRepository;
    }

    public function handle()
    {
        try {
            $this->data['user_id'] = auth()->user()->id;

            return $this->followRepository->create($this->data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
