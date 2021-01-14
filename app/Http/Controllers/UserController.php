<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService){
        $this->userService = $userService;
    }

    public function update(Request $request){

        $request->validate([
            'first_name' => 'sometimes|required|string',
            'last_name' => 'sometimes|required|string',
            'email' => 'sometimes|required|string',
            'profile_image_url' => 'sometimes|nullable|string',

        ]);

        $response = $this->userService->update($request->toArray());

        return response()->json(['message' => $response['message'],'data'=>$response['data']],
            $response['status']);
    }



    public function get(Request $request){

        $response = $this->userService->getUser();

        return response()->json(['message' => $response['message'],
            'data'=>$response['data']],
            $response['status']);
    }

    public function invite(Request $request){

        $request->validate([
            'first_name' => 'required|string',
            'email' => 'required|string|email',
            'scopes' => 'required|string'
        ]);

        $response = $this->userService->inviteUser($request->toArray());

        return response()->json(['message' => $response['message'],
            'data'=>$response['data']],
            $response['status']);
    }

    public function getUsers(Request $request){

        $response = $this->userService->getUsers( $request->pageSize);

        return response()->json(['message' => $response['message'],'data'=>$response['data']],
            $response['status']);
    }

    public function getUserById($id){

        $response = $this->userService->getUserById( $id);

        return response()->json(['message' => $response['message'],'data'=>$response['data']],
            $response['status']);
    }


    public function updateUserById(Request $request, $id){


        $response = $this->userService->updateUserById($request->toArray(), $id);

        return response()->json(['message' => $response['message']],
            $response['status']);
    }

    public function getUsersWithFilters(Request $request){

        $response = $this->userService->getUsersWithFilters($request->toArray(), $request->pageSize);

        return response()->json(['message' => $response['message'],'data'=>$response['data']],
            $response['status']);
    }


}
