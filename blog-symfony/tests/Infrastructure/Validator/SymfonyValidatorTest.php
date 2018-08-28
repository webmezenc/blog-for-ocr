<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 16:07
 */

namespace App\Tests\Infrastructure\Validator;

use App\Entity\TestUnit;
use App\Infrastructure\Validator\SymfonyValidator;
use Phalcon\Validation\Validator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ValidatorBuilder;

class SymfonyValidatorTest extends TestCase
{

    public function setUp() {
        $validatorBuilder = new ValidatorBuilder();
        $this -> validator = $validatorBuilder  -> enableAnnotationMapping()
                                                -> getValidator();
    }

    public function testShouldObtainAValidationWithAValidEntity() {
        $testUnit = new TestUnit();
        $testUnit -> value = "test";
        $symfonyValidator = new SymfonyValidator($this -> validator );
        $this -> assertTrue($symfonyValidator -> validate($testUnit));

    }

    public function testShouldObtainAListOfErrors() {
        $testUnit = new TestUnit();
        $symfonyValidator = new SymfonyValidator($this -> validator );
        $symfonyValidator -> validate($testUnit);

        $this -> assertInternalType("array",$symfonyValidator -> getErrors());
    }

    public function testShouldObtainAnValidationErrors() {
        $testUnit = new TestUnit();
        $symfonyValidator = new SymfonyValidator($this -> validator );
        $this -> assertFalse($symfonyValidator -> validate($testUnit));
    }

    public function testWhenValidAnEntityButEntityIsntValidObject() {

        $this -> expectException("\App\Exception\EntityNotValidException");

        $symfonyValidator = new SymfonyValidator($this -> validator );
        $symfonyValidator -> validate("test");

    }
}
