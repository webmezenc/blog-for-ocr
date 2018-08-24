<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 22/08/2018
 * Time: 16:56
 */

namespace App\Security\User;

use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class BlogUser implements UserInterface, EquatableInterface
{


    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $salt;

    /**
     * @var array
     */
    private $roles;


    /**
     * BlogUser constructor.
     *
     * @param array $roles
     * @param string $password
     * @param string $salt
     * @param string $username
     */
    public function __construct( array $roles, string $password, string $salt, string $username ) {
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
        $this->roles = $roles;
    }


    public function getRoles()
    {
        return $this -> roles;
    }

    public function getPassword()
    {
        return $this -> password;
    }

    public function getSalt()
    {
        return $this -> salt;
    }

    public function getUsername()
    {
        return $this -> username;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


    public function isEqualTo(UserInterface $user)
    {

        if (!$user instanceof BlogUser) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }


        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

}