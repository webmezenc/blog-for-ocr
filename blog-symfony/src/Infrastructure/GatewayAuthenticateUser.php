<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 17:24
 */

namespace App\Infrastructure;

use App\Entity\User;

interface GatewayAuthenticateUser
{
    public function getUser(): ?User;
}