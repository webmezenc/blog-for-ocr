<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 10/09/2018
 * Time: 18:20
 */

namespace App\Tests\Domain\Command\User;

use App\Domain\Command\User\CommandUser;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class CommandUserTest extends TestCase
{

    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }

    public function testShouldObtainAUserWhenUserIsExist() {
        $commandUser = new CommandUser($this->getRepository());
        $commandUser->setId(1);
        $user = $commandUser->getUser();

        $this->assertInstanceOf("\App\Entity\User",$user);
    }

    public function testShouldDeleteAUserButUserIsntExist() {
        $this->expectException("\App\Exception\EntityNotFoundException");

        $commandUser = new CommandUser($this->getRepository());
        $commandUser->setId(99999);
        $commandUser->getUser();
    }

    public function testShouldDeleteAUserButUserIdIsntDefined() {
        $this->expectException("\App\Exception\ParameterUndefinedException");
        $commandUser = new CommandUser($this->getRepository());
        $commandUser->getUser();
    }

    private function getRepository() {
        $repositoryFactory = new RepositoryFactory($this->container);
        return $repositoryFactory->create("User","inMemory");
    }
}
