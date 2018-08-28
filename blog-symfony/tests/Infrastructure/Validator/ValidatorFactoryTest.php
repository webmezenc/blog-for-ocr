<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 16:29
 */

namespace App\Tests\Infrastructure\Validator;

use App\Infrastructure\Validator\ValidatorFactory;
use PHPUnit\Framework\TestCase;

class ValidatorFactoryTest extends TestCase
{

    public function testShouldObtainAValidValidator() {

        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create("Symfony");

        $this -> assertInstanceOf("\App\Infrastructure\InfrastructureValidatorInterface",$validator);
    }


    public function testShouldObtainAnErrorWhenValidatorIsntExist() {
        $this -> expectException("\App\Exception\InfrastructureAdapterException");

        $validatorFactory = new ValidatorFactory();
        $validatorFactory -> create("UnitTest");
    }
}
