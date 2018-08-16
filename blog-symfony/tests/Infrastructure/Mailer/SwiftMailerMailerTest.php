<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 20:23
 */

namespace App\Tests\Infrastructure\Mailer;

use App\Infrastructure\Mailer\SwiftMailerMailer;
use PHPUnit\Framework\TestCase;

class SwiftMailerMailerTest extends TestCase
{
    /**
     * @var SwiftMailerMailer
     */
    private $swiftMailer;

    public function setUp() {
        $transport = new \Swift_SendmailTransport();
        $this -> swiftMailer = new SwiftMailerMailer( new \Swift_Mailer( $transport ) );
    }

    public function testShouldObtainErrorInSendingEmailWhenNoSpecifySender() {

    }

    public function testShouldObtainErrorWhenEmailInToIsInvalid() {
        $this -> expectException("\App\Exception\EmailInvalidException");
        $this -> swiftMailer -> addTo("contact_at_google.com");
    }

}
