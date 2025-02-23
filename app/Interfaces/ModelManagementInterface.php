<?php

namespace App\Interfaces;

interface ModelManagementInterface
{
    /**
     * Create a new model instance
     *
     * @param string $model
     * @param array $records
     * @return mixed
     */
    public function create(array $records);

    /**
     * Update a model instance
     *
     * @param string $model
     * @param int $id
     * @param array $records
     * @return mixed
     */
    public function update(int $id, array $records = []);

    /**
     * Delete a model instance
     *
     * @param string $model
     * @param int $id
     * @return void
     */
    public function delete(int $id);

    /**
     * Get a model instance
     *
     * @param string $model
     * @param int $id
     * @return mixed
     */
    public function get(int $id);
}
