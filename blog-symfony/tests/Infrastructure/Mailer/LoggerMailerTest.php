<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 15:02
 */

namespace App\Tests\Infrastructure\Mailer;

use App\Infrastructure\Mailer\LoggerMailer;
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

    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $this -> container = $kernel -> getDic();
    }


    public function testShouldObtainAValidWhenSendEmail() {

        $loggerMailer = new LoggerMailer( Validation::createValidator(), $this -> container -> get("logger.debug") );

        $loggerMailer -> addTo("contact@unittest.com");
        $loggerMailer -> setSender("contact@unittest.com");
        $loggerMailer -> setReplyTo("contact@unittest.com");
        $loggerMailer -> setSubject("Unit test");
        $loggerMailer -> setContent("Unit test ( testShouldObtainAValidWhenSendEmail )");
        $this -> assertTrue( $loggerMailer -> send() );

    }


    public function testShouldObtainAnErrorWhenEmailIsInvalid() {
        $this -> expectException("\App\Exception\EmailInvalidException");

        $loggerMailer = new LoggerMailer( Validation::createValidator(), $this -> container -> get("logger.debug") );

        $loggerMailer -> addTo("contact_at_unittest.com");
    }
}
