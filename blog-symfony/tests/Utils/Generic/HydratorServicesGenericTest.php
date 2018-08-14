<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 13/08/2018
 * Time: 12:01
 */

namespace App\Tests\Utils\Generic;

use App\Utils\Generic\HydratorServicesGeneric;
use PHPUnit\Framework\TestCase;

class HydratorServicesGenericTest extends TestCase
{

    public function testShouldObtainAnErrorWhenEntityNotFound() {
        $this -> expectException("\App\Exception\EntityNotFoundException");

        HydratorServicesGeneric::hydrate("UnitTest", [] );
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

        $User = HydratorServicesGeneric::hydrate( "User", $parameters );

        $this -> assertInstanceOf("\App\Entity\User", $User);
        $this -> assertEquals( "contact@webmezenc.com", $User -> getEmail() );

    }
}
