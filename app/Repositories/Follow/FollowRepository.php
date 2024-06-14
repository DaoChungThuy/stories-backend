<?php

namespace App\Repositories\Follow;

use App\Interfaces\Follow\FollowRepositoryInterface;
use App\Models\Follower;
use App\Repositories\BaseRepository;

class FollowRepository extends BaseRepository implements FollowRepositoryInterface
{
    public function __construct(Follower $follow)
    {
        $this->model = $follow;
    }
}
