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

    /**
     * follow book if not followed or unfollow if followed
     * @param array $data
     * @return bool
     */
    public function handleFollow($data)
    {
        $check = $this->model->firstOrNew([
            'user_id' => $data['user_id'],
            'book_id' => $data['book_id']
        ]);

        return $check->exists ? $check->delete() : $check->fill($data)->save();
    }

    /**
     * check user follow book or not
     * @param $book_id
     * @return bool
     */
    public function checkFollow($book_id)
    {
        return $this->model->where('book_id', $book_id)
            ->where('user_id', auth()->user()->id)
            ->exists();
    }
}
