<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 08/09/2018
 * Time: 16:32
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue42UseCases;
use App\Entity\Comments;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class Issue42UseCasesTest extends TestCase
{
    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }

    public function testShouldObtainAListOfCommentsWhenStateIsValid() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");

        $issue42UseCases = new Issue42UseCases($commentsRepository);
        $issue42UseCases -> setState(Comments::COMMENTS_VALID);
        $dataProcess = $issue42UseCases -> process();

        $this -> assertArrayHasKey("commentsList", $dataProcess );

        foreach($dataProcess["commentsList"] as $comments ) {
            $this -> assertEquals(Comments::COMMENTS_VALID,$comments -> getState());
        }

    }

    public function testShouldObtainAnErrorWhenStateCommentIsDefinedButInvalid() {
        $this -> expectException("\App\Exception\ParameterInvalidException");

        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");

        $issue42UseCases = new Issue42UseCases($commentsRepository);
        $issue42UseCases -> setState(999);
        $dataProcess = $issue42UseCases -> process();

    }

    public function testShouldObtainAListOfCommentsWhenStateIsntValid() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");

        $issue42UseCases = new Issue42UseCases($commentsRepository);
        $issue42UseCases -> setState(Comments::COMMENTS_INVALID);
        $dataProcess = $issue42UseCases -> process();

        $this -> assertArrayHasKey("commentsList", $dataProcess );

        foreach($dataProcess["commentsList"] as $comments ) {
            $this -> assertEquals(Comments::COMMENTS_INVALID,$comments -> getState());
        }

    }

    public function testShouldObtainAListOfComments() {

        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");

        $issue42UseCases = new Issue42UseCases($commentsRepository);
        $dataProcess = $issue42UseCases -> process();

        $this -> assertArrayHasKey("commentsList", $dataProcess );

    }
}
