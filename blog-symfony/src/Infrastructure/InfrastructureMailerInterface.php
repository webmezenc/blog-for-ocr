<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 20:16
 */

namespace App\Infrastructure;

use App\Entity\ValueObject\Mail;

interface InfrastructureMailerInterface
{
    public function addTo( string $email );
    public function setSender( string $email, string $name = null );
    public function setSubject( string $subject );
    public function setContent( string $content );
    public function setReplyTo( string $email );
    public function send(): bool;
    public function getEmailTemplate(string $templateName, Mail $mail): string;
    public function getMailValueObject(): Mail;
}