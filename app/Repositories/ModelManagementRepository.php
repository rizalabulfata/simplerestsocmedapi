<?php

namespace App\Repositories;

use App\Interfaces\ModelManagementInterface;
use Illuminate\Database\Eloquent\Model;

class ModelManagementRepository implements ModelManagementInterface
{

    /** @var Model */
    public Model $model;

    /**
     * Set the model instance
     * 
     * @param Model $model
     * @return void
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    /**
     * Get the model instance
     * 
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Create a new model instance
     *
     * @param array $records
     * @return Model
     */
    public function create(array $records, $relations = []): Model
    {
        return $this->model->create($records);
    }

    /**
     * Update a model instance
     *
     * @param int $id
     * @param array $records
     * @return Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(int $id, array $records = []): Model
    {
        $model = $this->model->findOrFail($id);
        $model->update($records);
        return $model;
    }

    /**
     * Delete a model instance
     *
     * @param int $id
     * @return bool
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function delete(int $id): bool
    {
        return $this->model->findOrFail($id)->delete();
    }

    /**
     * Get a model instance
     *
     * @param int $id
     * @return Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function get(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get a list of model instances
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all($columns);
    }
}
