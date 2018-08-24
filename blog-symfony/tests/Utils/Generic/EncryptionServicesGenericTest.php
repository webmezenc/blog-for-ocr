<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 22/08/2018
 * Time: 13:17
 */

namespace App\Tests\Utils\Generic;

use App\Utils\Generic\EncryptionServicesGeneric;
use PHPUnit\Framework\TestCase;

class EncryptionServicesGenericTest extends TestCase
{

    public function testShouldVerifyPasswordAndPasswordIsValid() {
        $this -> assertTrue( EncryptionServicesGeneric::verifyPassword("9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08", "test"));
    }

    public function testShouldVerifyPasswordANdIsInvalid() {
        $this -> assertNotTrue( EncryptionServicesGeneric::verifyPassword("9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08ererer", "test"));
    }

    public function testShouldObtainAValidHash() {
        $this -> assertNotNull( EncryptionServicesGeneric::passwordEncrypt("test") );
    }
}
