<?php

namespace App\Repositories\Interfaces;

interface BookRepositoryInterface {

    public function create($attributes);

    public function getUserBooks($user_id);

    public function getAllBooks();

    public function updateBook($attributes, $book_id);

    public function isExist($book_id);
}