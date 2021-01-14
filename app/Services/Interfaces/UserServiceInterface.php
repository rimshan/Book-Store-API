<?php

namespace App\Services\Interfaces;

interface UserServiceInterface {
    
    public function createUser(array $attributes);

    public function update(array $attributes);

    public function getUsers($pageSize);

    public function updateUserById(array $attributes, $userId);

    public function getUserById($userId);

    public function getUsersWithFilters(array $attributes, $pageSize);
}