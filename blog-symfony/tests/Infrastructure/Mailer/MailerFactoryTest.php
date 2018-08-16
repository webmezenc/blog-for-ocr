<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 14:39
 */

namespace App\Tests\Infrastructure\Mailer;

use App\Infrastructure\Mailer\MailerFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class MailerFactoryTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $this -> container = $kernel -> getDic();

    }

    public function testShouldObtainAValidLoggerMailer() {
        $MailerFactory = new MailerFactory( $this -> container );
        $LoggerMailer = $MailerFactory -> create('Logger' );

        $this -> assertInstanceOf("\App\Infrastructure\Mailer\LoggerMailer", $LoggerMailer );

    }

    public function testShouldObtainAValidSwiftMailer() {

        $MailerFactory = new MailerFactory( $this -> container );
        $SwiftMailer = $MailerFactory -> create('SwiftMailer' );

        $this -> assertInstanceOf("\App\Infrastructure\Mailer\SwiftMailerMailer", $SwiftMailer );
    }

    public function testShouldObtainAnErrorWhenMailerIsntDefined() {
        $this -> expectException("\App\Exception\InfrastructureAdapterException");

        $MailerFactory = new MailerFactory( $this -> container );
        $MailerFactory -> create('unitTest' );
    }

}
