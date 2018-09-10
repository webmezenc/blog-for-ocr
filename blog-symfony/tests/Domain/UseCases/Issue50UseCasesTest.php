<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 10/09/2018
 * Time: 18:05
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\Command\User\DeleteCommandUser;
use App\Domain\UseCases\Issue50UseCases;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class Issue50UseCasesTest extends TestCase
{

    private $container;

    private $repository;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }

    public function testShouldObtainASuccessMessageWhenUserIsDeleted() {
        $issue50UseCases = new Issue50UseCases($this->getDeleteCommandUser(),$this->getRepository());
        $issue50UseCases->setId(1);
        $dataProcess = $issue50UseCases->process();

        $this -> assertArrayHasKey("msg",$dataProcess);
        $this -> assertEquals("userSuccessfullDeleted",$dataProcess["msg"]);
    }

    public function testShouldDeleteAUserButUserIsntExist() {
        $this->expectException("\App\Exception\EntityNotFoundException");

        $issue50UseCases = new Issue50UseCases($this->getDeleteCommandUser(),$this->getRepository());
        $issue50UseCases->setId(99999);
        $issue50UseCases->process();
    }

    public function testShouldDeleteAUserButUserIdIsntDefined() {
        $this->expectException("\App\Exception\ParameterUndefinedException");
        $issue50UseCases = new Issue50UseCases($this->getDeleteCommandUser(),$this->getRepository());
        $issue50UseCases->process();
    }

    private function getDeleteCommandUser() {
        return new DeleteCommandUser($this->getRepository());
    }

    private function getRepository() {
        if(!isset($this->repository)) {
            $repositoryFactory = new RepositoryFactory($this->container);
            $this->repository = $repositoryFactory->create("User","inMemory");
        }

        return $this->repository;
    }

}
