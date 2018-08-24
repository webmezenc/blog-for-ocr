<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 22/08/2018
 * Time: 18:51
 */

namespace App\Security\User;


use App\Entity\Mapping\MappingUserToBlogUser;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Infrastructure\Repository\RepositoryFactory;
use Psr\Container\ContainerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Serializer\Exception\UnsupportedException;

class BlogUserProvider implements UserProviderInterface
{


    /**
     * @var RepositoryAdapterInterface
     */
    private $userRepository;


    /**
     * BlogUserProvider constructor.
     * @param ContainerInterface $container
     * @throws \App\Exception\InfrastructureAdapterException
     */
    public function __construct( ContainerInterface $container )
    {
        $repositoryFactory = new RepositoryFactory($container);
        $this -> userRepository = $repositoryFactory -> create("User", $container -> getParameter("repositoryProvider") );
    }


    /**
     * @param string $username
     * @return BlogUser|UserInterface
     */
    public function loadUserByUsername($username)
    {
        try {

            $user = $this -> userRepository -> findOneBy(
                ["email" => $username]
            );

            return MappingUserToBlogUser::mapping($user);

        } catch( \Exception $e ) {
            throw new UsernameNotFoundException(
                sprintf('Username "%s" does not exist.', $username)
            );
        }
    }

    /**
     * @param UserInterface $user
     * @return BlogUser|UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        if( !$user instanceof BlogUser ) {
            throw new UnsupportedUserException('Instance of "%s" are not supported', get_class($user));
        }

        return $this -> loadUserByUsername($user -> getUsername());
    }


    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return BlogUser::class === $class;
    }

}