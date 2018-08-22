<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 20:25
 */

namespace App\Infrastructure\Mailer;


use App\Entity\ValueObject\Mail;
use App\Exception\EmailAlreadyDefinedException;
use App\Exception\EmailInvalidParametersException;
use App\Exception\EmailTemplateException;
use App\Infrastructure\InfrastructureRenderInterface;
use App\Utils\Generic\ObjectServicesGeneric;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Mailer
{
    const PATH_TEMPLATE_MAIL = "email";
    const DEFAULT_SENT_EMAIL = "ba729208b7-aad1bd@inbox.mailtrap.io";
    const DEFAULT_SENT_NAME = "No-reply BlogOCR";
    const DEFAULT_REPLYTO_EMAIL = "contact@blogocr.com";

    /**
     * @var array
     */
    protected $to = [];

    /**
     * @var Mail
     */
    protected $mail;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var InfrastructureRenderInterface
     */
    protected $render;


    /**
     * Mailer constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct( ValidatorInterface $validator, InfrastructureRenderInterface $render )
    {
        $this -> validator = $validator;
        $this -> render = $render;
        $this -> mail = new Mail();
    }


    /**
     * @param array $to
     * @param string $from
     * @param string $subject
     * @param string $content
     * @param string|null $replyTo
     *
     * @return bool
     *
     * @throws EmailInvalidParametersException
     */
    public function rulesValidationInMailParameters( array $to, string $from, string $subject, string $content, string $replyTo = null ) {

        $Mail = new Mail();
        $Mail -> setReplyTo( $replyTo );
        $Mail -> setSubject( $subject );
        $Mail -> setFrom( $from );
        $Mail -> setContent( $content );
        $Mail -> setTo( $to );

        $ValidationsRules = $this -> validator -> validate($Mail);

        if( count($ValidationsRules) > 0 ) {
            throw new EmailInvalidParametersException(count($ValidationsRules)." rules were not respected ");
        }

        return true;

    }


    /**
     * @param string $email
     *
     * @throws EmailAlreadyDefinedException
     */
    public function addToInArray( string $email ) {

        if( in_array($email,$this -> to) ) {
            throw new EmailAlreadyDefinedException("Email ".$email." is already defined");
        }

        array_push($this -> to,$email);

    }


    /**
     * @param string $templateName
     * @param Mail $mail
     *
     * @return string
     *
     * @throws EmailTemplateException
     */
    public function getEmailTemplate(string $templateName, Mail $mail ): string {

        try {

            $params = ObjectServicesGeneric::getArrayFromObject( $mail );
            return $this -> render -> renderView(self::PATH_TEMPLATE_MAIL."/".$templateName, ["mail" => $params] );

        } catch( \Exception $e ) {
            throw new EmailTemplateException("An error has occurred during render template : ".$e -> getMessage());
        }

    }


    /**
     * @return Mail
     */
    public function getMailValueObject(): Mail
    {
        return $this -> mail;
    }


}