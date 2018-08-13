<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 13/08/2018
 * Time: 10:20
 */

namespace App\Utils\Services\User;


use App\Entity\User;
use App\Exception\EntityAlreadyExistException;
use App\Repository\UserRepository;

class UserServices
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserServices constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct( UserRepository $userRepository ) {
        $this -> userRepository = $userRepository;
    }


    /**
     * @param User $user
     *
     * @return User
     *
     * @throws EntityAlreadyExistException
     */
    public function register( User $user ): User {

        try {
            $this -> isRegistrable( $user );
        } catch( EntityAlreadyExistException $e ) {
            throw $e;
        }

    }


    /**
     * @param User $user
     *
     * @return bool
     *
     * @throws EntityAlreadyExistException
     */
    private function isRegistrable( User $user ): bool {

       $User =  $this -> userRepository -> findOneBy( array("email" => $user -> getEmail() ));

       if( $User instanceof User ) {
           throw new EntityAlreadyExistException("User identified by ".$user -> getEmail()." is already exist");
       }

       return true;

    }


}