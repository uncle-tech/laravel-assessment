<?php

namespace App\Contracts;
use Illuminate\Support\Collection;

interface CRUD
{
    public function all() : Collection;

    public function create(array $data) : int;

    public function destroy(int $id) : bool;

    public function find(int $id);

    public function findBy(array $data) : Collection;

    public function update(int $id, array $data) : bool;
}
