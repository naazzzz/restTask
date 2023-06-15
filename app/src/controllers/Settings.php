<?php

namespace controllers;
require $_SERVER['DOCUMENT_ROOT']."/config/ResponseHandler.php";
require $_SERVER['DOCUMENT_ROOT']."/src/controllers/UserController.php";
require $_SERVER['DOCUMENT_ROOT']."/src/services/UserService.php";
use services\UserService;
use controllers\UserController;

class Settings {
    function __construct(
        private readonly \Doctrine\ORM\EntityManagerInterface $entityManager
    )
    {
    }

    public function GetControllerInstance($controller)
    {
        try {
            switch ($controller) {
                case "user":
                    $userService = new UserService($this->entityManager);
                    return new \controllers\UserController($userService);
                default:
//                header("HTTP/1.1 404 Not Found");
                    exit();
                    break;
            }
        } catch (Error $e) {
            sendError(array('error' => $e->getMessage()));
        }
        return null;
    }
}
