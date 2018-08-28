<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 17:27
 */

namespace App\Infrastructure\Gateway\AuthenticateUser;


use App\Entity\User;
use App\Exception\EntityNotValidException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Infrastructure\GatewayAuthenticateUser;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class SymfonyAuthenticateUser implements GatewayAuthenticateUser
{
    /**
     * @var RepositoryAdapterInterface
     */
    private $repository;

    /**
     * @var Security
     */
    private $security;


    /**
     * SymfonyAuthenticateUser constructor.
     *
     * @param RepositoryAdapterInterface $repository
     * @param Security $security
     */
    public function __construct( RepositoryAdapterInterface $repository, Security $security )
    {
        $this -> repository = $repository;
        $this -> security = $security;
    }


    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        $user = $this -> security -> getUser();

        if( is_null($user) ) {
            return null;
        }

        return $this->getUserInRepository($user);
    }

    /**
     * @param $user
     * @return null|User
     */
    private function getUserInRepository($user)
    {

        return $this->repository->findOneBy(
            ["email" => $user -> getUsername()]
        );

    }


}