<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 10/09/2018
 * Time: 19:00
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\Command\User\ActivateCommandUser;
use App\Domain\UseCases\Issue41UseCases;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class Issue41UseCasesTest extends TestCase
{

    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }

    public function testShouldObtainASuccessMessageWhenUserIsActivate() {
        $repositoryFactory = new RepositoryFactory($this->container);
        $userRepository = $repositoryFactory->create("User","inMemory");

        $activateCommandUser = new ActivateCommandUser($userRepository);

        $issue41UseCase = new Issue41UseCases($activateCommandUser,$userRepository);
        $issue41UseCase->setId(1);
        $dataProcess = $issue41UseCase->process();

        $this->assertArrayHasKey("msg",$dataProcess);
        $this->assertEquals("userSuccessfullActivate",$dataProcess["msg"]);
    }

    public function testShouldDeleteAUserButUserIdIsntDefined() {
        $this->expectException("\App\Exception\ParameterUndefinedException");

        $repositoryFactory = new RepositoryFactory($this->container);
        $userRepository = $repositoryFactory->create("User","inMemory");

        $activateCommandUser = new ActivateCommandUser($userRepository);

        $issue41UseCase = new Issue41UseCases($activateCommandUser,$userRepository);

        $issue41UseCase->process();
    }

}
