<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 22/08/2018
 * Time: 17:09
 */

namespace App\Tests\Security\User;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class MappingUserToBlogUserTest extends TestCase
{

    public function testShouldObtainAValidBlogUser() {
        $user = new User();
        $user -> setLevel(1);
        $user -> setPassword("9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08");
        $user -> setState(1);
        $user -> setEmail("contact@webmezenc.com");

        $this -> assertInstanceOf("\App\Security\User\BlogUser",\App\Entity\Mapping\MappingUserToBlogUser::mapping($user));
    }

    public function testShouldObtainAValidBlogUserButUserLevelIsntExist() {

        $this -> expectException("\App\Exception\ParameterInvalidException");
        
        $user = new User();
        $user -> setLevel(9999);
        
        \App\Entity\Mapping\MappingUserToBlogUser::mapping($user);
    }
}
