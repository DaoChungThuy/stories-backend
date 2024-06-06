<?php

namespace App\Interfaces\ServicePackage;

use App\Interfaces\CrudRepositoryInterface;

interface ServicePackageRepositoryInterface extends CrudRepositoryInterface
{
    public function getServicePackagePopular($limit);
}
