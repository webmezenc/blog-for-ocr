<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 15:02
 */

namespace App\Tests\Infrastructure\Mailer;

use App\Infrastructure\InfrastructureRenderInterface;
use App\Infrastructure\Mailer\LoggerMailer;
use App\Infrastructure\Render\RenderFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validation;

class LoggerMailerTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * @var InfrastructureRenderInterface
     */
    private $render;

    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $this -> container = $kernel -> getDic();
        $renderFactory = new RenderFactory( $kernel -> getDic() );
        $this -> render = $renderFactory -> create();
    }


    public function testShouldObtainAValidWhenSendEmail() {

        $loggerMailer = new LoggerMailer( Validation::createValidatorBuilder() -> enableAnnotationMapping() -> getValidator(), $this -> container -> get("logger.debug"), $this -> render );

        $loggerMailer -> addTo("contact@unittest.com");
        $loggerMailer -> setSender("contact@unittest.com");
        $loggerMailer -> setReplyTo("contact@unittest.com");
        $loggerMailer -> setSubject("Unit test");
        $loggerMailer -> setContent("Unit test ( testShouldObtainAValidWhenSendEmail )");
        $this -> assertTrue( $loggerMailer -> send() );

    }


    public function testShouldObtainAnErrorWhenEmailIsInvalid() {
        $this -> expectException("\App\Exception\EmailInvalidException");

        $loggerMailer = new LoggerMailer( Validation::createValidatorBuilder() -> enableAnnotationMapping() -> getValidator(), $this -> container -> get("logger.debug"), $this -> render );

        $loggerMailer -> addTo("contact_at_unittest.com");
    }
}
