<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 09/09/2018
 * Time: 18:50
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\Command\Comment\PublishCommandComment;
use App\Domain\UseCases\Issue45UseCases;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class Issue45UseCasesTest extends TestCase
{
    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }


    public function testShouldObtainAMessageSuccessfullWhenDeleteComment() {

        $issue45UseCases = new Issue45UseCases($this->getPublishCommandComment(),$this ->getRepository());
        $issue45UseCases->setId(1);
        $dataProcess = $issue45UseCases -> process();

        $this -> assertArrayHasKey("msg",$dataProcess);
        $this -> assertEquals("commentSuccessfullPublish",$dataProcess["msg"]);
    }

    public function testShouldObtainAnErrorWhenParameterIsntDefined() {
        $this -> expectException("\App\Exception\ParameterUndefinedException");
        $issue45UseCases = new Issue45UseCases($this -> getPublishCommandComment(),$this ->getRepository());
        $dataProcess = $issue45UseCases -> process(); 
    }

    /**
     * @return PublishCommandComment
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getPublishCommandComment(): PublishCommandComment {
        $commentsRepository = $this->getRepository();
        
        return new PublishCommandComment($commentsRepository);
        
    }

    /**
     * @return \App\Infrastructure\Repository\Entity\RepositoryAdapterInterface
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getRepository(): \App\Infrastructure\Repository\Entity\RepositoryAdapterInterface
    {
        $repositoryFactory = new RepositoryFactory($this->container);
        $commentsRepository = $repositoryFactory->create("Comments", "inMemory");
        return $commentsRepository;
    }
}
