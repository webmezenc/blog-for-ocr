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
use App\Exception\EntityNotFoundException;
use App\Infrastructure\Repository\Entity\UserRepositoryAdapterInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\ORMException;

class UserServices
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserServices constructor.
     *
     * @param UserRepositoryAdapterInterface $userRepository
     */
    public function __construct( UserRepositoryAdapterInterface $userRepository ) {
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

            return $this -> userRepository -> getEntityManager() -> persist( $user );

        } catch( ORMException $e ) {

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


        try {
            $User =  $this -> userRepository -> findOneBy( array("email" => $user -> getEmail() ));

            if( $User instanceof User ) {
                throw new EntityAlreadyExistException("User identified by ".$user -> getEmail()." is already exist");
            }

            return true;

        } catch( EntityNotFoundException $e ) {
            return true;
        }


    }


}