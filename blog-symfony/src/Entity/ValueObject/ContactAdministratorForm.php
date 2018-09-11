<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 28/08/2018
 * Time: 12:38
 */

namespace App\Entity\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

class ContactAdministratorForm
{

    /**
     * @var string
     * @Assert\Email()
     */
    public $email;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $subject;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="100")
     */
    public $message;
}