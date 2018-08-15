<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/08/2018
 * Time: 15:00
 */

namespace App\Tests\Utils\Generic;

use App\Utils\Generic\ObjectServicesGeneric;
use PHPUnit\Framework\TestCase;

class ObjectServicesGenericTest extends TestCase
{

    private $object;


    public function setUp() {

        $this -> object = new unitTest();

    }

    public function testWhenAValidObjectThenObtainArrayWithParametersValue()
    {
        $this -> assertInternalType("array", ObjectServicesGeneric::getArrayFromObject($this -> object));
    }


    public function testWhenObjectIsNotValidObject() {
        $this -> expectException("\App\Exception\TypeErrorException");

        ObjectServicesGeneric::getArrayFromObject( true );
    }




    public function testShouldObtainAValidSetter() {
        $this -> assertTrue( ObjectServicesGeneric::isSetter("name",$this -> object ) );
    }


    public function testShouldObtainErrorWhenObtainASetterButObjectIsInvalid() {

        $this -> expectException("\App\Exception\TypeErrorException");

        ObjectServicesGeneric::isSetter("name",false );
    }


}


class unitTest {

    private $name = "test";
    private $role = "unit test";

    public function setName( $name ) {
        $this -> name = $name;
    }

    public function setRole( $role ) {
        $this -> role = $role;
    }
}