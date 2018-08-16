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
use Symfony\Component\Config\Definition\Builder\ValidationBuilder;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\ValidatorBuilder;

class MailerTest extends TestCase
{


    public function testShouldObtainAnErrorDuringMailParametersValidation() {
        $this -> expectException("\App\Exception\EmailInvalidParametersException");

        $Mailer = new Mailer( Validation::createValidator() );
        $Mailer -> rulesValidationInMailParameters( array(), "", "", "" );

    }

    public function testShouldObtainAnErrorWhenEmailReceiverIsAlreadyDefined() {

        $this -> expectException("\App\Exception\EmailAlreadyDefinedException");

        $Mailer = new Mailer( Validation::createValidator() );

        $Mailer -> addToInArray("contact@webmezenc.com");
        $Mailer -> addToInArray("contact@webmezenc.com");

    }
}
