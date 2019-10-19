<?php

namespace App\Repository\Criteria;

use App\Repository\Contact\RepositoryInterface as Repository;
use App\Repository\Contact\RepositoryInterface;


abstract class Criteria {
    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public abstract function apply($model, Repository $repository);
}