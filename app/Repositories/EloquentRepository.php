<?php

namespace App\Repositories;
use App\Contracts\CRUD;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class EloquentRepository implements CRUD
{
    protected abstract function model() : Model;
    protected abstract function validFields() : array;

    protected function getValidFields($data) : array
    {
        return \array_filter($data, function($field) {
            return \in_array($field, $this->validFields());
        }, \ARRAY_FILTER_USE_KEY);
    }

    public function all() : Collection
    {
        return $this->model()->all();
    }

    public function create(array $data) : int
    {
        $model = $this->model();
        foreach ($this->getValidFields($data) as $field => $value) {
            $model->$field = $value;
        }

        $model->save();
        return $model->id;
    }

    public function destroy($id) : bool
    {
        return $this->model()->destroy($id);
    }

    public function find(int $id) : ?Model
    {
        return $this->model()->find($id);
    }

    public function findIn(array $ids) : Collection
    {
        return $this->model()->find($ids);
    }

    public function findBy(array $data) : Collection
    {
        return $this->model()
                    ->where($this->getValidFields($data) ?: 0)
                    ->get();
    }

    public function update(int $id, array $data) : bool
    {
        $model = $this->find($id);
        if (\is_null($model) || count($this->getValidFields($data)) < 1)
            return false;

        foreach ($this->getValidFields($data) as $field => $value) {
            $model->$field = $value;
        }

        return $model->save();
    }
}
