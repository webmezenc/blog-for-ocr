<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 08/09/2018
 * Time: 14:23
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue19UseCases;
use App\Entity\User;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class Issue19UseCasesTest extends TestCase
{

    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }

    public function testShouldObtainActiveUsersList() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("User");

        $issue19UseCases = new Issue19UseCases($postRepository);
        $issue19UseCases -> setStateUser(User::USER_ACTIVE);
        $dataProcess = $issue19UseCases -> process();

        $this -> assertArrayHasKey("userList",$dataProcess);
        $this -> assertInstanceOf("\App\Entity\User",$dataProcess["userList"][0] );

        foreach( $dataProcess["userList"] as $user ) {
            $this -> assertEquals(User::USER_ACTIVE,$user -> getState());
        }
    }

    public function testShouldObtainInactiveUsersList() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("User");

        $issue19UseCases = new Issue19UseCases($postRepository);
        $issue19UseCases -> setStateUser(User::USER_INACTIVE);
        $dataProcess = $issue19UseCases -> process();

        $this -> assertArrayHasKey("userList",$dataProcess);
        $this -> assertInstanceOf("\App\Entity\User",$dataProcess["userList"][0] );

        foreach( $dataProcess["userList"] as $user ) {
            $this -> assertEquals(User::USER_INACTIVE,$user -> getState());
        }
    }

    public function testShouldObtainAUsersListWhenADefinedStateButStateIsntValid() {
        $this -> expectException("\App\Exception\ParameterInvalidException");
        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("User");

        $issue19UseCases = new Issue19UseCases($postRepository);
        $issue19UseCases -> setStateUser(999);
    }

    public function testShouldObtainAUsersList() {

        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("User");

        $issue19UseCases = new Issue19UseCases($postRepository);
        $dataProcess = $issue19UseCases -> process();

        $this -> assertArrayHasKey("userList",$dataProcess);

    }

}
