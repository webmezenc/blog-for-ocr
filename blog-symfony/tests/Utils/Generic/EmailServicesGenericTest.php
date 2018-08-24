<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 09:01
 */

namespace App\Tests\Utils\Generic;

use App\Utils\Generic\EmailServicesGeneric;
use PHPUnit\Framework\TestCase;

class EmailServicesGenericTest extends TestCase
{

    public function testShouldObtainSuccessWhenEmailIsValid() {
        $this -> assertTrue( EmailServicesGeneric::validateEmail("contact@google.com"));
    }


    public function testShouldObtainErrorWhenEmailIsntValid() {

        $this -> expectException("\App\Exception\EmailInvalidException");

        EmailServicesGeneric::validateEmail("contact_at_google.com");

    }
}
