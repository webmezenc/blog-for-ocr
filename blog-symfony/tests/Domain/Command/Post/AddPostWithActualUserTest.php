<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 31/08/2018
 * Time: 19:03
 */

namespace App\Tests\Domain\Command\Post;

use App\Domain\Command\Post\AddPostWithActualUser;
use App\Entity\Post;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class AddPostWithActualUserTest extends TestCase
{
    private $container;

    public function setUp() {

        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }


    public function testShouldAddPostButUserIsntGrantedForThisAction() {
        $this -> expectException("\App\Exception\UserNotGrantedException");

    }

    public function testShouldAddPostButPostEntityIsntValid() {
        $this -> expectException("\App\Exception\EntityParametersErrorException");

        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();

        $addPostWithActualUser = new AddPostWithActualUser( $validator );
        $addPostWithActualUser -> addPost( new Post() );
    }
}
