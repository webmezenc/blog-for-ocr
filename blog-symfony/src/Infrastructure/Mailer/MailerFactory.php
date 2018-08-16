<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 14:38
 */

namespace App\Infrastructure\Mailer;


use App\Exception\InfrastructureAdapterException;
use App\Infrastructure\InfrastructureMailerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validation;

class MailerFactory
{

    const LIST_MAILER = ['SwiftMailer','Logger'];
    const DEFAULT_MAILER = 'Logger';

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct( ContainerInterface $container )
    {
        $this -> container = $container;
    }

    /**
     * @param string $mailerName
     *
     * @return InfrastructureMailerInterface
     *
     * @throws InfrastructureAdapterException
     */
    public function create( string $mailerName = self::DEFAULT_MAILER ): InfrastructureMailerInterface {

        if( !in_array($mailerName,self::LIST_MAILER) ) {
            throw new InfrastructureAdapterException("The mailer ".$mailerName." isn't defined");
        }

        $methodName = $this -> getMethodMailer($mailerName);

        if( !method_exists($this,$methodName) ) {
            throw new InfrastructureAdapterException("The mailer ".$mailerName." exist but method to return instance isn't defined");
        }

        return $this -> $methodName();

    }

    /**
     * @param string $mailerName
     * @return string
     */
    private function getMethodMailer( string $mailerName ): string {
        return "get".$mailerName."Mailer";
    }


    /**
     * @return LoggerMailer
     */
    private function getLoggerMailer(): LoggerMailer {
        return new LoggerMailer( Validation::createValidator(), $this -> container -> get("logger.debug") );
    }

    /**
     * @return SwiftMailerMailer
     */
    private function getSwiftMailerMailer(): SwiftMailerMailer {
        return new SwiftMailerMailer( Validation::createValidator(), $this -> container -> get("swiftmailer.mailer.default") );
    }

}