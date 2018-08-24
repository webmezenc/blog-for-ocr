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
use App\Infrastructure\InfrastructureRenderInterface;
use App\Infrastructure\Render\RenderFactory;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MailerFactory
{

    const LIST_MAILER = ['SwiftMailer','Logger'];
    const DEFAULT_MAILER = 'Logger';

    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * @var InfrastructureRenderInterface
     */
    private $render;


    /**
     * MailerFactory constructor.
     * @param ContainerInterface $container
     * @throws InfrastructureAdapterException
     */

    public function __construct( ContainerInterface $container )
    {
        $this -> container = $container;

        $renderFactory = new RenderFactory( $container);
        $this -> render = $renderFactory -> create();
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
        return new LoggerMailer(  $this -> getValidator(), $this -> container -> get("logger.debug"),$this -> render );
    }

    /**
     * @return SwiftMailerMailer
     */
    private function getSwiftMailerMailer(): SwiftMailerMailer {
        return new SwiftMailerMailer( $this -> getValidator(), $this -> container -> get("swiftmailer.mailer.default") );
    }

    /**
     * @return ValidatorInterface
     */
    private function getValidator(): ValidatorInterface {
        return Validation::createValidatorBuilder()
                        ->enableAnnotationMapping()
                        ->getValidator();
    }
}