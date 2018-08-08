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

        $this -> object = new \stdClass();
        $this -> object -> name = "test";
        $this -> object -> role = "unit test";

    }

    public function testWhenAValidObjectThenObtainArrayWithParametersValue()
    {
        $this -> assertInternalType("array", ObjectServicesGeneric::getArrayFromObject($this -> object));
    }


    public function testWhenObjectIsNotValidObject() {
        $this -> expectException("\App\Exception\TypeErrorException");

        ObjectServicesGeneric::getArrayFromObject( true );
    }
}
