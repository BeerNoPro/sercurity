<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

abstract class EloquentRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getAll()
    {
        $data = $this->model->paginate(6);
        return $data ? $data : false;
    }

    public function find($id)
    {
        $data = $this->model->find($id);
        return $data ? $data : false;
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    public function search($name)
    {
        $data = $this->model->where('name','like','%'.$name.'%')->get();
        return $data ? $data : false;
    }
    
}
