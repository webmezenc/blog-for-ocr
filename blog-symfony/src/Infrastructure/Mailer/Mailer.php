<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 20:25
 */

namespace App\Infrastructure\Mailer;


use App\Entity\ValueObject\Author;
use App\Entity\ValueObject\Mail;
use App\Exception\EmailAlreadyDefinedException;
use App\Exception\EmailInvalidParametersException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Mailer
{
    /**
     * @var array
     */
    protected $to = [];


    /**
     * @var ValidatorInterface
     */
    protected $validator;


    /**
     * Mailer constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct( ValidatorInterface $validator )
    {
        $this -> validator = $validator;
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

}