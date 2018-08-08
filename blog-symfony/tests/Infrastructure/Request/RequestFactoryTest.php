<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/08/2018
 * Time: 14:01
 */

namespace App\Tests\Infrastructure\Request;

use App\Infrastructure\Request\RequestFactory;
use PHPUnit\Framework\TestCase;

class RequestFactoryTest extends TestCase
{
    public function testShouldObtainValidRequest() {

        $this -> assertInstanceOf( "\App\Infrastructure\InfrastructureRequestInterface", RequestFactory::create() );

    }
}
