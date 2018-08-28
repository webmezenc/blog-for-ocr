<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 16:09
 */

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class TestUnit
{
    /**
     * @Assert\NotNull()
     */
    public $value;
}