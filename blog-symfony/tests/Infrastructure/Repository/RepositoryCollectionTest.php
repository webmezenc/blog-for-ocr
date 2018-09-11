<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 06/09/2018
 * Time: 15:36
 */

namespace App\Tests\Infrastructure\Repository;

use App\Infrastructure\Repository\RepositoryCollection;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class RepositoryCollectionTest extends TestCase
{

    /**
     * @var RepositoryFactory
     */
    private $repositoryFactory;

    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $container = $kernel -> getDic();
        $this -> repositoryFactory = new RepositoryFactory( $container );
    }

    public function testShouldObtainAnEmptyCollectionWhenRemoveAnUniqueRepository() {
        $postRepository = $this -> repositoryFactory -> create("Post","inMemory");
        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection -> add("Post",$postRepository);

        $repositoryCollection -> remove("Post");

        $this -> assertEquals(0,count($repositoryCollection -> all()));
    }

    public function testShouldObtainAnErrorWhenRemoveARepositoryNotFound() {
        $this -> expectException("\App\Exception\NotFoundException");
        $repositoryCollection = new RepositoryCollection();

        $repositoryCollection -> remove("unitTest");
    }


    public function testShouldObtainACollectionOfRepository() {
        $postRepository = $this -> repositoryFactory -> create("Post","inMemory");
        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection -> add("Post",$postRepository);

        $repositories = $repositoryCollection -> all();
        $this -> assertInstanceOf("\App\Infrastructure\Repository\Entity\RepositoryAdapterInterface",$repositories["Post"]);
    }

    public function testShouldObtainAnErrorWhenRepositoryIsAlreadyInCollection() {
        $this -> expectException("\App\Exception\AlreadyExistException");
        $postRepository = $this -> repositoryFactory -> create("Post","inMemory");
        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection -> add("Post",$postRepository);
        $repositoryCollection -> add("Post",$postRepository);

    }

    public function testShouldObtainARepositoryWhenRepositoryNameIsValid() {

        $postRepository = $this -> repositoryFactory -> create("Post","inMemory");
        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection -> add("Post",$postRepository);
        $this -> assertInstanceOf("\App\Infrastructure\Repository\Entity\RepositoryAdapterInterface",$repositoryCollection -> get("Post"));

    }

    public function testShouldObtainAnErrorWhenAccessToARepositoryNotFound() {
        $this -> expectException("\App\Exception\NotFoundException");

        $repositoryCollection = new RepositoryCollection();

        $repositoryCollection -> get("unittest");
    }
}
