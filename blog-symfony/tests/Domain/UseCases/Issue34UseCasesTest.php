<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/09/2018
 * Time: 12:56
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue34UseCases;
use App\Entity\Post;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Utils\Generic\ParametersBag;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class Issue34UseCasesTest extends TestCase
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }


    public function testShouldObtainAListOfPostContainPostsPublished() {
        $repositoryFactory = new RepositoryFactory($this->container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");

        $issue34UseCases = new Issue34UseCases( $postRepository,new ParametersBag( ["state" => Post::POST_PUBLISHED] ));
        $dataProcess = $issue34UseCases -> process();

        $this -> assertEquals(Post::POST_PUBLISHED, $dataProcess[0] -> getState());

    }

    public function testShouldObtainAListOfPostContainPostsInDraftStatus() {
        $repositoryFactory = new RepositoryFactory($this->container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");

        $issue34UseCases = new Issue34UseCases( $postRepository,new ParametersBag( ["state" => Post::POST_DRAFT] ));
        $dataProcess = $issue34UseCases -> process();

        $this -> assertEquals(Post::POST_DRAFT, $dataProcess[0] -> getState());
    }

    public function testShouldObtainAListOfPost() {

        $repositoryFactory = new RepositoryFactory($this->container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");

        $issue34UseCases = new Issue34UseCases( $postRepository,new ParametersBag() );

        $dataProcess = $issue34UseCases -> process();

        $this -> assertInstanceOf("\App\Entity\Post",$dataProcess[0]);
    }


}
