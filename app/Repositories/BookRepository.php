<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookRepository implements BookRepositoryInterface{

    public function create($attributes)
    {
        return Book::create($attributes);
    }

    public function getUserBooks($user_id)
    {
        return DB::table('books')
            ->join('users', 'books.user_id', '=', 'users.id')
            ->where('user_id', '=', $user_id)
            ->select('books.id', 'books.title', 'books.description', 'users.first_name as author_first_name', 'users.last_name as author_last_name')
            ->get();
    }

    public function getAllBooks()
    {
        return DB::table('books')
            ->join('users', 'books.user_id', '=', 'users.id')
            ->where('users.is_active', '=', 1)
            ->select('books.id', 'books.title', 'books.description', 'users.first_name as author_first_name', 'users.last_name as author_last_name')
            ->get();
    }

    public function updateBook($attributes, $book_id)
    {
        $book  = Book::find($book_id);
        $book->title = isset($attributes['title']) ? $attributes['title'] : $book->title;
        $book->description = isset($attributes['description']) ? $attributes['description'] : $book->description;

        $book->save();
    }

    public function isExist($book_id)
    {
        return Book::where('id', $book_id)->exists();
    }
}