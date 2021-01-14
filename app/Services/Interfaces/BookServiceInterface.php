<?php

namespace  App\Services\Interfaces;

interface BookServiceInterface {

    public function create(array $attributes);

    public function getUserBooks();

    public function getAllBooks();

    public function updateBook($attributes, $book_id);
}