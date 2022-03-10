<?php

namespace App\Repositories;

interface RepositoryInterface
{
    // Get all data
    public function getAll();

    // Get one data
    public function find($id);

    // Create data
    public function create(array $attributes);

    // Update data
    public function update($id, array $attributes);

    // Search data
    public function search($name);

}
