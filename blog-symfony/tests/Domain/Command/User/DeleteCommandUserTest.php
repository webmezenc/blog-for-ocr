<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 10/09/2018
 * Time: 18:31
 */

namespace App\Tests\Domain\Command\User;

use App\Domain\Command\User\DeleteCommandUser;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class DeleteCommandUserTest extends TestCase
{

    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }

    public function testShouldDeleteAUserAndDeleteIsSuccess() {
        $repositoryFactory = new RepositoryFactory($this->container);
        $userRepository = $repositoryFactory->create("User","inMemory");

        $deleteCommandUser = new DeleteCommandUser($userRepository);
        $this->assertTrue($deleteCommandUser->deleteUser(1));
    }

}
