<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/08/2018
 * Time: 11:50
 */

namespace App\Tests\Utils\Generic;

use App\Utils\Generic\FileServicesGeneric;
use App\Utils\Generic\InMemoryDataServicesGeneric;
use PHPUnit\Framework\TestCase;

class InMemoryDataServicesGenericTest extends TestCase
{

    private $inMemoryDataServices;

    public function setUp() {

        $this -> inMemoryDataServices = new InMemoryDataServicesGeneric( new FileServicesGeneric() );
    }


    public function testShouldFileIsCorrectlyOpenedAndValidJson() {
        $this -> assertInternalType("array", $this -> inMemoryDataServices -> getDataForEntity("Post") );
    }


    public function testShouldFileISCorrectlyOpenedButIsInvalidJson() {
        $this -> expectException("\App\Exception\FileIsNotValidJsonException");

        $this -> inMemoryDataServices -> getDataForEntity( "TestFileIsNotValidJson" );
    }


    public function testShouldFileIsCorrectlyOpenedButIsEmpty() {
        $this -> expectException("\App\Exception\FileEmptyException");

        $this -> inMemoryDataServices -> getDataForEntity( "TestFileEmpty" );
    }

    public function testTheFileIsntFound() {

        $this -> expectException("\App\Exception\FileNotFoundException");

        $this -> inMemoryDataServices -> getDataForEntity( "Test" );
    }
}
