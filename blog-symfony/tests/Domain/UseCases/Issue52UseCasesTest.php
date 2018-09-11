<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 10/09/2018
 * Time: 21:14
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue52UseCases;
use App\Entity\Comments;
use App\Entity\Post;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class Issue52UseCasesTest extends TestCase
{
    private $container;

    private $commentsRepository;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();

        $repositoryFactory = new RepositoryFactory($this->container);
        $this -> commentsRepository = $repositoryFactory->create("Comments","inMemory");

    }


    public function testShouldObtainCommentsWhenPostContainComments() {

        $issue52UseCases = new Issue52UseCases($this -> commentsRepository);
        $issue52UseCases->setPost($this->getPost());
        $dataProcess = $issue52UseCases->process();

        $this->assertArrayHasKey("commentsList", $dataProcess);
        $this->assertInstanceOf("\App\Entity\Comments",$dataProcess["commentsList"][0]);

        foreach( $dataProcess["commentsList"] as $comments ) {
            $this -> assertEquals(Comments::COMMENTS_VALID,$comments->getState());
        }
    }

    public function testShouldObtainAnErrorWhenPostIsNotDefined() {
        $this->expectException("\App\Exception\ParameterUndefinedException");
        $issue52UseCases = new Issue52UseCases($this -> commentsRepository);
        $issue52UseCases->process();
    }

    private function getPost() {
        $post = new Post();
        $post->setId(1);

        return $post;
    }
}
