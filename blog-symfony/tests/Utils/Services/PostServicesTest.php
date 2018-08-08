<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/08/2018
 * Time: 11:23
 */

namespace App\Tests\Utils\Services;

use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Utils\Services\Post\PostServices;
use PHPUnit\Framework\TestCase;

class PostServicesTest extends TestCase
{


    private $postServices;

    public function setUp() {

        $kernel = KernelFactory::getKernel();

        $repositoryFactory = new RepositoryFactory( $kernel -> getDic() );

        $postRepository = $repositoryFactory -> create("Post");


        $this -> postServices = new PostServices( $postRepository );

    }


    public function testPostIsValidAndPublished() {
        $this -> assertInstanceOf("\App\Entity\Post", $this -> postServices -> getPublishPostBySlug("blog-is-open") );
    }


    public function testPostIsExistButIsNotPublished() {
        $this -> expectException("\App\Exception\InvalidStateException");

        $this -> postServices -> getPublishPostBySlug("unittestnotpublished");
    }

    public function testPostIsNotExistObtainErrorNotFound() {

        $this -> expectException("\App\Exception\EntityNotFoundException");

        $this -> postServices -> getPublishPostBySlug("unitest");

    }
}
