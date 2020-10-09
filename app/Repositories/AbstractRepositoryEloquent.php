<?php

namespace App\Repositories;

use App\Contracts\Repositories\AbstractRepository;

abstract class AbstractRepositoryEloquent implements AbstractRepository
{
    protected $model;

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->model(), $method], $parameters);
    }

    abstract public function model();

    public function store($data)
    {
        return $this->model()->create($data);
    }
}
