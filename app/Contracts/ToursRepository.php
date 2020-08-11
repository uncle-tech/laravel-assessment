<?php

namespace App\Contracts;

interface ToursRepository extends CRUD
{
    public function createWithId(int $id, array $data) : bool;
}
