<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 20:25
 */

namespace App\Infrastructure\Mailer;


use App\Exception\EmailAlreadyDefinedException;

class Mailer
{
    /**
     * @var array
     */
    protected $to = [];

    /**
     * @var string
     */
    protected $sender;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $replyTo;


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