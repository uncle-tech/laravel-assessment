<?php

namespace App\Services;

class ToursService
{
    protected function repository()
    {
        return app()->make('App\Contracts\ToursRepository');
    }

    protected function updateId($newId, $createdId)
    {
        if (\is_numeric($newId) && \is_numeric($createdId))
            return $this->repository()->update($createdId, [
                'id' => $newId,
            ]);
    }

    public function createOrUpdate($id, $data)
    {
        if (!empty($this->repository()->find($id)))
            return $this->repository()->update($id, $data);

        return $this->updateId($id, $this->repository()->create($data));
    }
}
