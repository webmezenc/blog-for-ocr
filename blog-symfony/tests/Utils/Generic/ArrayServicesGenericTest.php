<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 19:48
 */

namespace App\Tests\Utils\Generic;

use App\Utils\Generic\ArrayServicesGeneric;
use PHPUnit\Framework\TestCase;

class ArrayServicesGenericTest extends TestCase
{


    public function testShouldASuccessWhenAllKeysAreInArray() {
        $this -> assertTrue( ArrayServicesGeneric::allKeysAreInArray(['unitTest'], ['unitTest' => 'test']));
    }


    public function testShouldObtainAnExceptionWhenKeyIsntFoundInArray() {
        $this -> expectException("\App\Exception\ParameterIsNotFoundException");

        ArrayServicesGeneric::allKeysAreInArray( ["unitTest"], ["test" => "test"] );
    }



    public function testShouldDeleteArrayElementInArray() {

        $elementToDelete = ["test" => "test"];
        $arrInput = [
            $elementToDelete,
            ["essai" => "essai"]
        ];

        $this -> assertEquals(1, count(ArrayServicesGeneric::deleteElementInArray($arrInput,$elementToDelete)));
    }
}
