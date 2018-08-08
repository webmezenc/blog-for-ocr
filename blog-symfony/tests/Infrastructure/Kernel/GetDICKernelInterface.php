<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/08/2018
 * Time: 10:52
 */

namespace App\Tests\Infrastructure\Kernel;


use Psr\Container\ContainerInterface;

interface GetDICKernelInterface
{
    public function getDic(): ContainerInterface;
}