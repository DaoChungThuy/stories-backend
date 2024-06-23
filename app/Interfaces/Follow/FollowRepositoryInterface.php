<?php

namespace App\Interfaces\Follow;

use App\Interfaces\CrudRepositoryInterface;

interface FollowRepositoryInterface extends CrudRepositoryInterface
{
    public function handleFollow($data);

    public function checkFollow($book_id);

    public function countFollow($book_id);
}
