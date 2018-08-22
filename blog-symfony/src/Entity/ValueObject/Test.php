<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 12:29
 */

namespace App\Entity\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

class Test
{
    /**
     * @Assert\IsNull()
     */
    private $test;

    /**
     * @return mixed
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param mixed $test
     */
    public function setTest($test): void
    {
        $this->test = $test;
    }


}