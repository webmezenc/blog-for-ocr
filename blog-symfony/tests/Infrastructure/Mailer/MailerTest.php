<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 20:27
 */

namespace App\Tests\Infrastructure\Mailer;

use App\Infrastructure\Mailer\Mailer;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{

    public function testShouldObtainAnErrorWhenEmailReceiverIsAlreadyDefined() {

        $this -> expectException("\App\Exception\EmailAlreadyDefinedException");

        $Mailer = new Mailer();

        $Mailer -> addToInArray("contact@webmezenc.com");
        $Mailer -> addToInArray("contact@webmezenc.com");

    }
}
