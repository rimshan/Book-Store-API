<?php 

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\UserServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface {


    protected $userRepository;


    public function __construct( UserRepositoryInterface $userRepository){
        $this->userRepository = $userRepository;
    }

    public function createUser(array $attributes){

        try{

            $is_exist = $this->userRepository->getByEmail($attributes['email']);
            if($is_exist){
                return ['status' => 410, 'message'=>'The email address is already taken. Please choose another one.'];
            }

            DB::beginTransaction();

            // activate the user
            $attributes['is_active'] = true;
            $attributes['password'] = bcrypt($attributes['password']);
            $user = $this->userRepository->create($attributes);

            DB::commit();

            return ['status' => 201, 'message'=>'You have successfully registered.'];
        }
        catch(Exception $e)
        {
            DB::rollback();
            return ['status' => 500, 'message'=>$e->getMessage()];
        }
    }

    public function update(array $attributes){

        try{
            if($this->userRepository->isExist( Auth::user()->id)){

                $update_user =  $this->userRepository->update($attributes, Auth::user()->id);

                return ['status' => 201, 'message'=>'User successfully updated.', 'data'=>$update_user];
            }
            else {
                return ['status' => 410, 'message'=>'User does not exist.'];
            }
        }
        catch(Exception $e)
        {
            return ['status' => 410, 'message'=>$e->getMessage()];
        }
    }

    public function updateUserById(array $attributes, $userId)
    {
        try{
            DB::beginTransaction();
            if(!$this->userRepository->isExist($userId)){
                return ['status' => 410, 'message'=>'User does not exist.'];
            }
            $this->userRepository->updateUserById($attributes, $userId);
            DB::commit();
            return ['status' => 201, 'message'=>'User successfully updated.'];
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return ['status' => 410, 'message'=>$e->getMessage()];
        }
    }

    public function getUser(){

        $userId = Auth::user()->id;
        $user = $this->userRepository->getUser($userId);

        return ['status' => 201, 'message'=>'', 'data'=>$user];
    }

    public function getUserById($userId)
    {
        $user = $this->userRepository->getUserById($userId);

        return ['status' => 201, 'message'=>'', 'data'=>$user];
    }


    public function getUsers($pageSize)
    {
        try{
            $users = $this->userRepository->getUsers( $pageSize);
            $message = sizeof($users)==0?'There are no users.':'';

            return ['status' => 201, 'message'=>$message, 'data'=>$users];

        }catch (Exception $e){
            return ['status' => 410, 'message'=>$e->getMessage(), 'data'=>null];
        }
    }

    public function getUsersWithFilters(array $attributes, $pageSize)
    {
        try{
            $users = $this->userRepository->getUsersWithFilters($attributes,  $pageSize);
            $message = sizeof($users)==0?'There are no users.':'';

            return ['status' => 201, 'message'=>$message, 'data'=>$users];

        }catch (Exception $e){
            return ['status' => 410, 'message'=>$e->getMessage(), 'data'=>null];
        }
    }


}