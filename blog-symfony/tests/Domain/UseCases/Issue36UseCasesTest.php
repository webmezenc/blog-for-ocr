<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/09/2018
 * Time: 20:11
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\Command\Post\DeletePostWithActualUser;
use App\Domain\UseCases\Issue36UseCases;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class Issue36UseCasesTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $repositories;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();

        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");

        $this -> repositories = ["post" => $postRepository];
    }

    public function testShouldObtainAnSuccessMessageWhenPostIsDeletedSuccessfull() {
        $issue36UseCase = new Issue36UseCases($this -> repositories["post"],$this ->getDeletePostWIthActualUser());
        $issue36UseCase->setSlug("post23");
        $dataProcess = $issue36UseCase->process();
        $this -> assertArrayHasKey("msg",$dataProcess);
        $this -> assertEquals(Issue36UseCases::POST_DELETE_SUCCESS,$dataProcess["msg"]);
    }

    public function testShouldObtainAnErrorWhenSlugCorrespondingToAPostNotExist() {
        $this -> expectException("\App\Exception\EntityNotFoundException");

        $issue36UseCase = new Issue36UseCases($this -> repositories["post"],$this ->getDeletePostWIthActualUser());
        $issue36UseCase->setSlug("unittestnotfound");
        $issue36UseCase->process();
    }

    public function testShouldObtainAnErrorWhenSlugIsEmpty() {
        $this -> expectException("\App\Exception\ParameterIsNotFoundException");

        $issue36UseCase = new Issue36UseCases($this -> repositories["post"],$this ->getDeletePostWIthActualUser());
        $issue36UseCase->process();
    }


    private function getDeletePostWIthActualUser() {
        $authenticateUserFactory = new AuthenticateUserFactory($this -> container);
        $authenticateUser = $authenticateUserFactory -> create("inMemory");

        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();

        return new DeletePostWithActualUser($authenticateUser,$validator,$this -> repositories["post"]);
    }

}
