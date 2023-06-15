<?php

namespace services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use entities\User;

require $_SERVER['DOCUMENT_ROOT']."/config/bootstrap.php";

class UserService
{
    private User $user;
    function __construct(
        private readonly EntityManagerInterface $em
    )
    {
    }

    /**
     * @throws ORMException
     * @throws \Exception
     */
    public function saveUser($data){
        $this->setUser(new User($data['carId'],$data['name'],password_hash($data['password'],PASSWORD_DEFAULT)));
        //Создает сущность в entityManager которой в дальнейшем занимается entity manager для взаимодействия достаточно flush
        $this->em->persist($this->getUser());
        $this->em->flush();

        return json_encode($this->user);
    }

    public function getAll(){
        $userRepository = $this->em->getRepository(User::class);
        $users = $userRepository->findAll();
        return json_encode($users);
    }

    public function getUserById(int $id)
    {

        $userRepository = $this->em->getRepository(User::class);
        $user_now = $userRepository->find($id);

        if ($user_now === null) {
            echo "No user found.\n";
            exit(1);
        }

        return json_encode($user_now);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updateUser($data){

        $userRepository = $this->em->getRepository(User::class);
        $user_now = $userRepository->find($data["id"]);

        if ($user_now === null) {
            echo "No user found.\n";
            exit(1);
        }
        $user_now->setName($data['name']);
        $user_now->setCarId($data['carId']);
        $user_now->setPassword(password_hash($data['password'],PASSWORD_DEFAULT));
        $user_now->setDateUpdate(date('Y-m-d'));


        $this->em->flush();

        return json_encode($user_now);
    }


    public function deleteUser($data){
        $userRepository = $this->em->getRepository(User::class);
        $user_now = $userRepository->find($data["id"]);
        if ($user_now === null) {
            echo "No user found.\n";
            exit(1);
        }
        $this->em->remove($user_now);
        $this->em->flush();
        return "OK";
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

}
