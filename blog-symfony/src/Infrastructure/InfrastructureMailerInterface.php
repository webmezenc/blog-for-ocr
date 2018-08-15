<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 20:16
 */

namespace App\Infrastructure;


interface InfrastructureMailerInterface
{
    public function addTo( string $email );
    public function setSender( string $email );
    public function setSubject( string $subject );
    public function setContent( string $content );
    public function setReplyTo( string $email );
    public function send(): bool;
}