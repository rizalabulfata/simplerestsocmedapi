<?php

namespace App\Services;

use App\Repositories\ModelManagementRepository;
use Illuminate\Database\Eloquent\Model;

class ModelManagementService
{
    /** @var ModelManagementRepository */
    protected ModelManagementRepository $repository;

    /**
     * Initialize the Model
     * 
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->repository = new ModelManagementRepository();
        $this->repository->setModel($model);
    }

    /**
     * Get a list of data with relations
     * 
     * @param array $columns
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListDataWithRelations($columns = ['*'], $relations = []): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->getModel()->with($relations)->get($columns);
    }

    /**
     * Get a list of data
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListData($columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->all($columns);
    }

    /**
     * Create a new model
     * 
     * @param array $records
     */
    public function createData(array $records): Model
    {
        return $this->repository->create($records);
    }

    /**
     * Update a model
     * 
     * @param int $id
     * @param array $records
     */
    public function updateData(int $id, array $records): Model
    {
        return $this->repository->update($id, $records);
    }

    /**
     * Delete a model
     * 
     * @param int $id
     * @return array [Status, Data]
     */
    public function deleteData(int $id): array
    {
        $row = $this->repository->get($id);
        $status = $this->repository->delete($id);

        return [$status, $row];
    }

    /**
     * Get a model
     * 
     * @param int $id
     * @return Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getData(int $id): Model
    {
        return $this->repository->get($id);
    }
}
