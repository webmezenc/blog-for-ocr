<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 20:27
 */

namespace App\Tests\Infrastructure\Mailer;

use App\Entity\ValueObject\Mail;
use App\Infrastructure\InfrastructureRenderInterface;
use App\Infrastructure\Mailer\Mailer;
use App\Infrastructure\Render\RenderFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\ValidationBuilder;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\ValidatorBuilder;

class MailerTest extends TestCase
{

    /**
     * @var InfrastructureRenderInterface
     */
    private $render;


    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $renderFactory = new RenderFactory( $kernel -> getDic() );
        $this -> render = $renderFactory -> create();
    }



    public function testShouldObainEmailTemplateAndTemplateIsValid() {

        $Mailer = new Mailer( Validation::createValidatorBuilder() -> enableAnnotationMapping() -> getValidator(),$this -> render );
        $Mailer -> getEmailTemplate("emailunittest.html.twig",$this -> getMail() );

        $this -> assertEquals( "Une template pour les tests unitaires : test|test",$Mailer -> getEmailTemplate("emailunittest.html.twig",$this -> getMail() ) );
    }


    public function testShouldObtainEmailTemplateButErrorIsFoundInTemplate() {
        $this -> expectException("\App\Exception\EmailTemplateException");

        $Mailer = new Mailer( Validation::createValidatorBuilder() -> enableAnnotationMapping() -> getValidator(),$this -> render );
        $Mailer -> getEmailTemplate("unittestnotfound",$this -> getMail() );
    }


    public function testShouldObtainAnErrorDuringMailParametersValidation() {
        $this -> expectException("\App\Exception\EmailInvalidParametersException");

        $Mailer = new Mailer( Validation::createValidatorBuilder() -> enableAnnotationMapping() -> getValidator(),$this -> render );
        $Mailer -> rulesValidationInMailParameters( array(), "", "", "" );

    }

    public function testShouldObtainAnErrorWhenEmailReceiverIsAlreadyDefined() {

        $this -> expectException("\App\Exception\EmailAlreadyDefinedException");

        $Mailer = new Mailer( Validation::createValidatorBuilder() -> enableAnnotationMapping() -> getValidator(), $this -> render );

        $Mailer -> addToInArray("contact@webmezenc.com");
        $Mailer -> addToInArray("contact@webmezenc.com");

    }

    private function getMail(): Mail {

        $Mail = new Mail();
        $Mail -> setSubject("test");
        $Mail -> setReplyTo("test");
        $Mail -> setFrom("test");
        $Mail -> setTo([]);

        return $Mail;
    }
}
