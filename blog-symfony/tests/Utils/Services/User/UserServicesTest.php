<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 13/08/2018
 * Time: 10:21
 */

namespace App\Tests\Utils\Services\User;

use App\Entity\User;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Utils\Services\User\UserServices;
use PHPUnit\Framework\TestCase;

class UserServicesTest extends TestCase
{
    private $userServices;

    public function setUp() {
        $kernel = KernelFactory::getKernel();

        $repositoryFactory = new RepositoryFactory( $kernel -> getDic() );
        $userRepository = $repositoryFactory -> create("User" );

        $this -> userServices = new UserServices( $userRepository );
    }


    public function testShouldObtainEntityWhenUserIsRegistred() {

        $User = new User();
        $User -> setEmail( "contact@webmezenc.com" );

        $this -> assertInstanceOf("\App\Entity\User", $this -> userServices -> register( $User ) );

    }

    public function testShouldObtainExceptionWhenUserIsAlreadyExist() {

        $this -> expectException("\App\Exception\EntityAlreadyExistException");

        $User = new User();
        $User -> setEmail( "contact@webmezenc.com" );

        $this -> userServices -> register( $User );

    }
}
