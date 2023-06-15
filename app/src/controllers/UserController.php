<?php

namespace controllers;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use entities\User;
use Error;
use services\UserService;

class UserController
{

    public function __construct(
        private readonly UserService $userService
    )
    {
    }

    public function getUserCollectionAction($data):void{
        try {
            $response_data=$this->userService->getAll();
            sendSuccess($response_data);
        }catch (Error $e){
            sendError(array('error' => $e->getMessage()));
        }
    }

    public function getUserAction($data):void{
        try {
            $response_data=$this->userService->getUserById($data['id']);
            sendSuccess($response_data);
        }catch (Error $e){
            sendError(array('error' => $e->getMessage()));
        }
    }

    public function userUpdatePostAction($data):void{
        try {
            $response_data=$this->userService->updateUser($data);
            sendSuccess($response_data);
        }catch (Error $e){
            sendError(array('error' => $e->getMessage()));
        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
        }
    }

    public function userDeletePostAction($data):void{
        try {
            $response_data=$this->userService->deleteUser($data);
            sendSuccess($response_data);
        }catch (Error $e){
            sendError(array('error' => $e->getMessage()));
        }
    }

    public function saveUserPostAction($data):void{
        try {
            $response_data=$this->userService->saveUser($data);
            sendSuccess($response_data);
        }catch (Error $e){
            sendError(array('error' => $e->getMessage()));
        } catch (ORMException|\Exception $e) {
        }
    }
}