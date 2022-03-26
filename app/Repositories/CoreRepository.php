<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

/**
 * Class CoreRepository
 * @package App\Repositories
 *
 * Репозиторий работы с сущьностью.
 * Может выдавать наборы данных.
 * Не может соходавать/изменятль сущности.
 */
abstract class CoreRepository
{
    /**
     * @var Model;
     */
    protected $model;

    /**
     * CoreRepository constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * @return \Illuminate\Contracts\Foundation\Application|Model|mixed
     */
    protected function startConditions()
    {
        return clone $this->model;
    }



}
