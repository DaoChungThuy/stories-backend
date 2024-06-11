<?php

namespace App\Interfaces\User;

use App\Interfaces\CrudRepositoryInterface;

interface UserRepositoryInterface extends CrudRepositoryInterface
{
    public function findByEmail($email);

    public function vertifyEmail($token);

    public function getListAuthors($id);

    public function getMyStorys($id);
}
