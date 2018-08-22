<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 15:01
 */

namespace App\Infrastructure\Mailer;


use App\Entity\ValueObject\Mail;
use App\Infrastructure\InfrastructureMailerInterface;
use App\Infrastructure\InfrastructureRenderInterface;
use App\Utils\Generic\EmailServicesGeneric;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoggerMailer extends Mailer implements InfrastructureMailerInterface
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LoggerMailer constructor.
     *
     * @param ValidatorInterface $validator
     * @param LoggerInterface $logger
     * @param InfrastructureRenderInterface $render
     */
    public function __construct(ValidatorInterface $validator, LoggerInterface $logger, InfrastructureRenderInterface $render )
    {
        parent::__construct($validator,$render);
        $this -> logger = $logger;
        $this -> mail = new Mail();
    }

    public function addTo(string $email)
    {
        EmailServicesGeneric::validateEmail($email);

        $arrEmail = $this -> mail -> getTo();
        $arrEmail[] = $email;
        $this -> mail -> setTo( $arrEmail );
    }

    public function setSender(string $email, string $name = null)
    {
        $this -> mail -> setFrom($email);
    }

    public function setSubject(string $subject)
    {
        $this -> mail -> setSubject($subject);
    }

    public function setContent(string $content)
    {
        $this -> mail -> setContent($content);
    }

    public function setReplyTo(string $email)
    {
        $this -> mail -> setReplyTo($email);
    }

    public function send(): bool
    {
        $msgToLogger = $this -> createMessageWithMailForLogger( $this -> mail );
        $this -> logger -> debug( $msgToLogger );

        return true;
    }

    /**
     * @param Mail $mail
     *
     * @return string
     */
    private function createMessageWithMailForLogger( Mail $mail ): string {

        $msg = "Date : ".date('Y-m-d H:i:s')."\r\n";
        $msg .= "From : ".$mail -> getFrom()."\r\n";
        $msg .= "To : ".serialize($mail -> getTo() )."\r\n";
        $msg .= "Reply-To : ".$mail -> getReplyTo()."\r\n";
        $msg .= "Subject : ".$mail -> getSubject()."\r\n";
        $msg .= "Content : ".$mail -> getContent();

        return $msg;
    }

}