<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 13/08/2018
 * Time: 12:01
 */

namespace App\Tests\Utils\Generic;

use App\Utils\Generic\HydratorServicesGeneric;
use App\Utils\Generic\ObjectServicesGeneric;
use PHPUnit\Framework\TestCase;

class HydratorServicesGenericTest extends TestCase
{

    public function testShouldObtainAnErrorWhenEntityNotFound() {
        $this -> expectException("\App\Exception\EntityNotFoundException");

        $hydratorServices = new HydratorServicesGeneric( new ObjectServicesGeneric() );
        $hydratorServices -> hydrate("UnitTest", [] );
    }

    public function testShouldObtainAValidUserEntityWithParameters() {

        $parameters = [
            "id" => 1,
            "firstname"=> "Jérémy",
            "lastname"=> "Gaultier",
            "email"=> "contact@webmezenc.com",
            "password"=> "empty",
            "state"=> 1,
            "level"=> 2
        ];

        $hydratorServices = new HydratorServicesGeneric( new ObjectServicesGeneric() );
        $User = $hydratorServices -> hydrate( "User", $parameters );

        $this -> assertInstanceOf("\App\Entity\User", $User);
        $this -> assertEquals( "contact@webmezenc.com", $User -> getEmail() );

    }
}
