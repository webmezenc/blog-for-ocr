<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/09/2018
 * Time: 20:24
 */

namespace App\Tests\Domain\Command\Post;

use App\Domain\Command\Post\DeletePostWithActualUser;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class DeletePostWithActualUserTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }

    public function testShouldObtainNoErrorWhenPostIsDeletedAndPostIsExist() {

        $authenticateUserFactory = new AuthenticateUserFactory($this -> container);
        $authenticateUser = $authenticateUserFactory -> create("inMemory");

        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();

        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");

        $deletePostWithactualUser = new DeletePostWithActualUser($authenticateUser,$validator,$postRepository);

        $this -> assertEmpty($deletePostWithactualUser -> deletePost("post23"));
    }


    public function testShouldObtainAnErrorWhenDeletePostButPostIsntExist() {
        $this -> expectException("\App\Exception\EntityNotFoundException");

        $authenticateUserFactory = new AuthenticateUserFactory($this -> container);
        $authenticateUser = $authenticateUserFactory -> create("inMemory");

        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();

        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");

        $deletePostWithactualUser = new DeletePostWithActualUser($authenticateUser,$validator,$postRepository);

        $deletePostWithactualUser -> deletePost("unittestnotfound");
    }
}
