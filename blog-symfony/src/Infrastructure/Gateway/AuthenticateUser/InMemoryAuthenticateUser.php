<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 20:18
 */

namespace App\Infrastructure\Gateway\AuthenticateUser;


use App\Entity\User;
use App\Infrastructure\GatewayAuthenticateUser;

class InMemoryAuthenticateUser implements GatewayAuthenticateUser
{
    public function getUser(): ?User
    {
        return new User();
    }
}