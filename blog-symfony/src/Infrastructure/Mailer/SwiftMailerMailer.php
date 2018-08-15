<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 20:22
 */

namespace App\Infrastructure\Mailer;


use App\Infrastructure\InfrastructureMailerInterface;

class SwiftMailerMailer extends Mailer implements InfrastructureMailerInterface
{
    public function addTo(string $email)
    {
        // TODO: Implement addTo() method.
    }

    public function setSender(string $email)
    {
        // TODO: Implement setSender() method.
    }

    public function setSubject(string $subject)
    {
        // TODO: Implement setSubject() method.
    }

    public function setContent(string $content)
    {
        // TODO: Implement setContent() method.
    }

    public function setReplyTo(string $email)
    {
        // TODO: Implement setReplyTo() method.
    }

    public function send(): bool
    {
        // TODO: Implement send() method.
    }

}