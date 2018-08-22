<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/08/2018
 * Time: 10:52
 */

namespace App\Tests\Infrastructure\Kernel;

use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class SymfonyKernel extends KernelTestCase implements GetDICKernelInterface
{
    public function getDic(): ContainerInterface
    {
        self::bootKernel();
        return self::$kernel -> getContainer();
    }
}