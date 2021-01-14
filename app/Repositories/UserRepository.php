<?php

namespace App\Repositories;

use DB;
use App\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserRepository implements UserRepositoryInterface {

    public function create(array $attributes){

        return User::create($attributes);
    }

    public function update(array $attributes, $userId){

        $user = User::find($userId);
        $user->first_name = isset($attributes['first_name']) ? $attributes['first_name']  : $user->first_name;
        $user->last_name = isset($attributes['last_name']) ? $attributes['last_name']  : $user->last_name;
        $user->email = isset($attributes['email']) ? $attributes['email']  : $user->email;
        $user->contact_number = isset($attributes['contact_number']) ? $attributes['contact_number']  : $user->contact_number;

        $user->save();

        return $user;
    }

    public function updateUserById(array $attributes, $userId)
    {
        $user = User::find($userId);
        $user->first_name = isset($attributes['first_name']) ? $attributes['first_name']  : $user->first_name;
        $user->last_name = isset($attributes['last_name']) ? $attributes['last_name']  : $user->last_name;
        $user->contact_number = isset($attributes['contact_number']) ? $attributes['contact_number']  : $user->contact_number;
        $user->is_active = isset($attributes['is_active']) ? $attributes['is_active'] : $user->is_active;

        $user->save();
    }

    public function isExist($userId){
        return User::where('id', $userId)->exists();
    }


    public function getUserById($userId)
    {
        return User::where('id', $userId)->select('id','first_name', 'last_name', 'email','contact_number', 'is_active')->first();
    }

    public function getByEmail($email){
        return User::where('email', $email)->first();
    }

    public function getUsers($pageSize)
    {
        return DB::table('users')
            ->select('users.id','users.first_name', 'users.last_name', 'users.email', 'users.contact_number',  'users.is_active')
            ->get();
    }

    public function getUsersWithFilters(array $attributes, $pageSize)
    {
        return DB::table('users')
            ->where(function ($q) use ($attributes) {
                $q->where('users.first_name', 'like', '%'.$attributes['filters']['search'].'%')->orWhere('users.last_name', 'like', '%'.$attributes['filters']['search'].'%');})
            ->select('users.id','users.first_name', 'users.last_name', 'users.email', 'users.contact_number','users.date_of_birth',  'users.is_active')
            ->paginate($pageSize);
    }

    public function getUser($userId)
    {
        return User::find($userId);
    }

}