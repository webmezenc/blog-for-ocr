<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 14/08/2018
 * Time: 20:56
 */

namespace App\Tests\Utils\Generic;

use App\Utils\Generic\EntityServicesGeneric;
use PHPUnit\Framework\TestCase;

class EntityServicesGenericTest extends TestCase
{


    public function testWhenEntityIsValid() {
        $this -> assertTrue( EntityServicesGeneric::isExist("User") );
    }


    public function testShouldObtainErrorWhenEntityIsntExist() {
        $this -> expectException("\App\Exception\EntityNotFoundException");
        EntityServicesGeneric::isExist("UnitTest");
    }


    public function testShouldObtainAValidClassName() {
        $this -> assertEquals( "\App\Entity\User",  EntityServicesGeneric::getClassName("User") );
    }

}
