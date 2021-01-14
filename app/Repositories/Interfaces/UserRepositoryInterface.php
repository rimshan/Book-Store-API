<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface {
    
    public function create(array $attributes);

    public function update(array $attributes, $userId);

    public function isExist( $userId);

    public function getByEmail($email);

    public function getUsers($pageSize);

    public function getUserById($userId);


    public function getUsersWithFilters(array $attributes, $pageSize);

    public function getUser($userId);
}