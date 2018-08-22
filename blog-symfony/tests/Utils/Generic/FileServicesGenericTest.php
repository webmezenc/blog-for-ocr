<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/08/2018
 * Time: 12:13
 */

namespace App\Tests\Utils\Generic;

use App\Utils\Generic\FileServicesGeneric;
use PHPUnit\Framework\TestCase;

class FileServicesGenericTest extends TestCase
{

    private $fileServices;

    public function setUp() {
        $this -> fileServices = new FileServicesGeneric();
    }



    public function testObtainTheContentFile() {


       $this -> assertEquals("This is a test file",$this -> fileServices -> getContentFile("unitTest.test"));

    }


    public function testTheFileIsntFound() {

        $this -> expectException("App\Exception\FileNotFoundException");

        $this -> fileServices -> getContentFile("unitTestError.test");
    }

}
