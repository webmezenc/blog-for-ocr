<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 04/08/2018
 * Time: 13:00
 */

namespace App\Infrastructure;


use Psr\Container\ContainerInterface;

interface InfrastructureRepositoryFactoryInterface
{
    static public function create( string $name, string $provider, ContainerInterface $container );
}