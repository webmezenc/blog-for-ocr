<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/08/2018
 * Time: 10:46
 */

namespace App\Tests\Infrastructure\Repository;

use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class RepositoryFactoryTest extends TestCase
{


    private $repositoryFactory;

    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $container = $kernel -> getDic();
        $this -> repositoryFactory = new RepositoryFactory( $container );
    }

    public function testObtainExceptionWhenGetUndefinedMethodRepository() {

        $this -> expectException("\App\Exception\InfrastructureAdapterException");

        $this -> repositoryFactory -> create("Post","mongodb");
    }

    public function testObtainExceptionWhenGetBadRepository() {

        $this -> expectException( "\App\Exception\InfrastructureAdapterException");

        $this -> repositoryFactory -> create("test","essai");

    }

    public function testObtainADoctrineRepository() {

        $doctrineRepository = $this -> repositoryFactory -> create("Post","doctrine");

        $this -> assertInstanceOf(RepositoryAdapterInterface::class, $doctrineRepository );

    }


    public function testObtainAInMemoryRepository() {

        $inMemoryRepository = $this -> repositoryFactory -> create("User","inMemory");

        $this -> assertInstanceOf(RepositoryAdapterInterface::class, $inMemoryRepository );

    }


}
