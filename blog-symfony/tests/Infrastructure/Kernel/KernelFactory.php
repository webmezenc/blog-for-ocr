<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/08/2018
 * Time: 10:55
 */

namespace App\Tests\Infrastructure\Kernel;


class KernelFactory
{
    static public function getKernel( string $framework = "symfony" ) {

        return new SymfonyKernel();

    }
}