<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 10/09/2018
 * Time: 19:07
 */

namespace App\Tests\Domain\Command\User;

use App\Domain\Command\User\ActivateCommandUser;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class ActivateCommandUserTest extends TestCase
{
    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }

    public function testShouldObtainSuccessWhenActivateValidUser() {
        $repositoryFactory = new RepositoryFactory($this->container);
        $userRepository = $repositoryFactory->create("User","inMemory");

        $activateCommandUser = new ActivateCommandUser($userRepository);
        $this->assertTrue($activateCommandUser->activateUser(1));
    }
}
