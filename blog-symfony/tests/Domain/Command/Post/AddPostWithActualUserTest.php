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
use App\Entity\PostCategory;
use App\Entity\User;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Tests\Infrastructure\Gateway\NotAuthenticateUserStub;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class AddPostWithActualUserTest extends TestCase
{
    private $container;

    public function setUp() {

        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }


    public function testShouldAddPostAndPostIsAddedCorrectly() {


        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();

        $authenticateUserFactory = new AuthenticateUserFactory($this -> container);
        $authenticateUser = $authenticateUserFactory -> create("inMemory");

        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");


        $addPostWithActualUser = new AddPostWithActualUser( $validator,$authenticateUser,$postRepository );
        $post = $addPostWithActualUser -> addPost( $this -> getPost() );

        $this -> assertInstanceOf("\App\Entity\Post",$post);
    }


    public function testShouldAddPostButUserIsNotAuthenticate() {
        $this -> expectException("\App\Exception\UnhautorizedException");

        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");

        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();

        $addPostWithActualUser = new AddPostWithActualUser( $validator,new NotAuthenticateUserStub(),$postRepository );

        $addPostWithActualUser -> addPost( $this -> getPost() );
    }

    public function testShouldAddPostButPostEntityIsntValid() {
        $this -> expectException("\App\Exception\EntityParametersErrorException");

        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();

        $authenticateUserFactory = new AuthenticateUserFactory($this -> container);
        $authenticateUser = $authenticateUserFactory -> create("inMemory");

        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");


        $addPostWithActualUser = new AddPostWithActualUser( $validator,$authenticateUser,$postRepository );
        $addPostWithActualUser -> addPost( new Post() );
    }



    private function getPost(): Post {

        $post = new Post();
        $post -> setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
        $post -> setTitle("PHP unit test");
        $post -> setState(0);
        $post -> setSlug("phpunit-test");
        $post -> setDateCreate( new \DateTimeImmutable() );
        $post -> setHeadcontent("Head content of post");
        $post -> setIdPostCategory( new PostCategory() );

        return $post;

    }
}

