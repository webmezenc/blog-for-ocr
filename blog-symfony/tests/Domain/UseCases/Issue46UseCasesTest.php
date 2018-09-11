<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 09/09/2018
 * Time: 14:43
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue46UseCases;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class Issue46UseCasesTest extends TestCase
{

    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }

    public function testShouldDeleteACommentAndObtainAnErrorMessage() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");


        $issue46UseCases = new Issue46UseCases($commentsRepository);
        $issue46UseCases->setIdComment(1);
        $dataProcess = $issue46UseCases -> process();

        $this->assertArrayHasKey("msg",$dataProcess);
        $this->assertEquals("commentSuccessfullDeleted",$dataProcess["msg"]);
    }

    public function testShouldDeleteACommentButCommentIsntExist() {
        $this -> expectException("\App\Exception\EntityNotFoundException");

        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");


        $issue46UseCases = new Issue46UseCases($commentsRepository);
        $issue46UseCases->setIdComment(99999);
        $issue46UseCases -> process();
    }

    public function testShouldObtainAnErrorWhenIdCommentsIsntFound() {
        $this -> expectException("\App\Exception\ParameterIsNotFoundException");

        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");

        $issue46UseCases = new Issue46UseCases($commentsRepository );
        $issue46UseCases -> process();
    }
    
}
