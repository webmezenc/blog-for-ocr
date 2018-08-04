<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 04/08/2018
 * Time: 13:00
 */

namespace App\Infrastructure\Repository;

use App\Infrastructure\InfrastructureRepositoryFactoryInterface;
use Psr\Container\ContainerInterface;

class RepositoryFactory implements InfrastructureRepositoryFactoryInterface
{

    const PROVIDER_LIST = ['doctrine'];

    public static function create(string $name, string $provider, ContainerInterface $container )
    {
        // TODO: Implement create() method.
    }

}