<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 20:23
 */

namespace App\Tests\Infrastructure\Mailer;

use App\Infrastructure\InfrastructureRenderInterface;
use App\Infrastructure\Mailer\SwiftMailerMailer;
use App\Infrastructure\Render\RenderFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\SwiftmailerBundle\DependencyInjection\SwiftmailerTransportFactory;
use Symfony\Component\Validator\Validation;

class SwiftMailerMailerTest extends TestCase
{
    /**
     * @var SwiftMailerMailer
     */
    private $swiftMailer;


    /**
     * @var InfrastructureRenderInterface
     */
    private $render;


    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @throws \App\Exception\InfrastructureAdapterException
     */

    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $renderFactory = new RenderFactory( $kernel -> getDic() );
        $this -> render = $renderFactory -> create();
        $this -> container = $kernel -> getDic();

        $transport = new \Swift_SendmailTransport();
        $this -> swiftMailer = new SwiftMailerMailer( Validation::createValidatorBuilder() -> enableAnnotationMapping() -> getValidator(), new \Swift_Mailer( $transport ), $this -> render );
    }

    public function testShouldObtainErrorInSendingEmailWhenNoSpecifySender() {

        $swiftMailer = new SwiftMailerMailer( Validation::createValidatorBuilder() -> enableAnnotationMapping() -> getValidator(), $this -> container -> get("swiftmailer.mailer.default"), $this -> render );


        $swiftMailer -> setReplyTo("replyto@unittest.com");
        $swiftMailer -> setSender($this -> container -> getParameter("email")["from"]);
        $swiftMailer -> setSubject("Test");
        $swiftMailer -> setContent("Unit test");

        $this -> assertTrue($swiftMailer -> send());

    }

    public function testShouldObtainErrorWhenEmailInToIsInvalid() {
        $this -> expectException("\App\Exception\EmailInvalidException");
        $this -> swiftMailer -> addTo("contact_at_google.com");
    }

}
