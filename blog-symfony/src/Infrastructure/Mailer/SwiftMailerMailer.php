<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 20:22
 */

namespace App\Infrastructure\Mailer;


use App\Exception\EmailSendErrorException;
use App\Infrastructure\InfrastructureMailerInterface;
use App\Infrastructure\InfrastructureRenderInterface;
use App\Utils\Generic\EmailServicesGeneric;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SwiftMailerMailer extends Mailer implements InfrastructureMailerInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Swift_Message
     */
    private $message;


    /**
     * SwiftMailerMailer constructor.
     *
     * @param ValidatorInterface $validator
     * @param \Swift_Mailer $mailer
     * @param InfrastructureRenderInterface $render
     */
    public function __construct( ValidatorInterface  $validator, \Swift_Mailer $mailer, InfrastructureRenderInterface $render )
    {
        $this -> mailer = $mailer;
        $this -> message = new \Swift_Message();

        parent::__construct( $validator,$render );
    }

    /**
     * @param string $email
     *
     * @throws \App\Exception\EmailInvalidException
     */
    public function addTo(string $email)
    {
        EmailServicesGeneric::validateEmail($email);
        $this -> message -> addTo( $email );
    }

    /**
     * @param string $email
     * @param string|null $name
     *
     * @throws \App\Exception\EmailInvalidException
     */
    public function setSender(string $email, string $name = null)
    {
        EmailServicesGeneric::validateEmail($email);
        $this -> message -> setFrom( $email, $name );
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this -> message -> setSubject($subject);
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this -> message -> setBody($content);
    }


    /**
     * @param string $email
     */
    public function setReplyTo(string $email)
    {
        $this -> message -> setReplyTo( $email );
    }


    /**
     * @return bool
     *
     * @throws EmailSendErrorException
     */
    public function send(): bool
    {
        if( $this -> mailer -> send( $this -> message ) === 0 ) {
            throw new EmailSendErrorException("An error has occurred when sent email");
        } else {
            return true;
        }
    }





}