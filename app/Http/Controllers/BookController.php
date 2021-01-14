<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\BookServiceInterface;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }

    public function create(Request $request){

        $request->validate([
            'title' => 'required|string'
        ]);

        $response = $this->bookService->create($request->toArray());

        return response()->json(['message' => $response['message'],'data'=>$response['data']],
            $response['status']);
    }

    public function getUserBooks(Request $request){

        $response = $this->bookService->getUserBooks();

        return response()->json(['message' => $response['message'],
            'data'=>$response['data']],
            $response['status']);
    }

    public function getAllBooks(Request $request){
        $response = $this->bookService->getAllBooks();

        return response()->json(['message' => $response['message'],
            'data'=>$response['data']],
            $response['status']);
    }

    public function updateBook(Request $request, $id){


        $response = $this->bookService->updateBook($request->toArray(), $id);

        return response()->json(['message' => $response['message']],
            $response['status']);
    }
}
