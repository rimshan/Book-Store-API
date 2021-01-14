<?php

namespace App\Services;

use App\Repositories\Interfaces\BookRepositoryInterface;
use App\Services\Interfaces\BookServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookService implements BookServiceInterface{

    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function create(array $attributes)
    {
        try{

            DB::beginTransaction();

            $user_id = Auth::user()->id;
            $attributes['user_id'] = $user_id;

            $book = $this->bookRepository->create($attributes);

            DB::commit();

            return ['status' => 201, 'message'=>'You have successfully created.' ,'data' => ''];
        }
        catch(Exception $e)
        {
            DB::rollback();
            return ['status' => 500, 'message'=>$e->getMessage()];
        }
    }

    public function getUserBooks()
    {
        try{

            $user_id = Auth::user()->id;
            $books = $this->bookRepository->getUserBooks($user_id);
            $message = sizeof($books)==0?'There are no books.':'';

            return ['status' => 201, 'message'=>$message, 'data'=>$books];

        }catch (Exception $e){
            return ['status' => 410, 'message'=>$e->getMessage(), 'data'=>null];
        }
    }

    public function getAllBooks()
    {
        try{
            $books = $this->bookRepository->getAllBooks();
            $message = sizeof($books)==0?'There are no books.':'';

            return ['status' => 201, 'message'=>$message, 'data'=>$books];

        }catch (Exception $e){
            return ['status' => 410, 'message'=>$e->getMessage(), 'data'=>null];
        }
    }

    public function updateBook($attributes, $book_id)
    {
        try{
            DB::beginTransaction();
            if(!$this->bookRepository->isExist($book_id)){
                return ['status' => 410, 'message'=>'Book does not exist.'];
            }
            $this->bookRepository->updateBook($attributes, $book_id);
            DB::commit();
            return ['status' => 201, 'message'=>'Book successfully updated.'];
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return ['status' => 410, 'message'=>$e->getMessage()];
        }
    }


}