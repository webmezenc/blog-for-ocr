<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 28/08/2018
 * Time: 16:56
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue10UseCases;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Utils\Services\Post\PostServices;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class Issue10UseCasesTest extends TestCase
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp() {

        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();

    }


    public function testShouldObtainAListOfFivePostOrBelow() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");

        $postServices = new PostServices( $postRepository );
        $issue10UseCases = new Issue10UseCases($postServices);

        $dataUseCases = $issue10UseCases -> process();

        if( count($dataUseCases["posts"]) <= 5 ) {
            $state = true;
        }

        $this -> assertTrue($state);
        $this -> assertInternalType("array",$dataUseCases["posts"][0]);
    }
}
