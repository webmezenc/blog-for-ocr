<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 03/09/2018
 * Time: 11:56
 */

namespace App\Tests\Infrastructure\Gateway;


use App\Entity\User;
use App\Infrastructure\GatewayAuthenticateUser;

class NotAuthenticateUserStub implements GatewayAuthenticateUser
{
    public function getUser(): ?User
    {
        return null;
    }
}