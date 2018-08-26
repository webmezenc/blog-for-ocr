<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 18:13
 */

namespace App\Infrastructure\Gateway\AuthenticateUser;


use App\Infrastructure\GatewayAuthenticateUser;
use App\Infrastructure\Repository\RepositoryFactory;
use Psr\Container\ContainerInterface;

class AuthenticateUserFactory
{
    const AUTHENTICATE_USER_LIST = ['Symfony','InMemory'];
    const DEFAULT_AUTHENTICATE_USER = 'Symfony';

    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * AuthenticateUserFactory constructor.
     * @param ContainerInterface $container
     */
    public function __construct( ContainerInterface $container )
    {
        $this -> container = $container;
    }

    /**
     * @param string $name
     *
     * @return GatewayAuthenticateUser
     *
     * @throws \App\Exception\InfrastructureAdapterException
     */
    public function create(string $name = self::DEFAULT_AUTHENTICATE_USER): GatewayAuthenticateUser {

        switch( $name ) {
            case "Symfony":
                return $this -> getSymfonyAuthenticateUser();
                break;
            case "InMemory":
                return $this -> getInMemoryAuthenticateUser();
                break;
        }

    }

    /**
     * @return InMemoryAuthenticateUser
     */
    private function getInMemoryAuthenticateUser() {
        return new InMemoryAuthenticateUser();
    }

    /**
     * @return SymfonyAuthenticateUser
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getSymfonyAuthenticateUser() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        $userRepository = $repositoryFactory -> create("User",$this -> container -> getParameter("repositoryProvider"));
        return new SymfonyAuthenticateUser($userRepository, $this -> container -> get("security.user"));
    }
}