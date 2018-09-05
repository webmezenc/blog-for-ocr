<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 28/08/2018
 * Time: 17:19
 */

namespace App\Tests\Repository\InMemory;

use App\Entity\ValueObject\OrderLimit;
use App\Repository\InMemory\PostRepository;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Utils\Generic\FileServicesGeneric;
use App\Utils\Generic\HydratorServicesGeneric;
use App\Utils\Generic\InMemoryDataServicesGeneric;
use App\Utils\Generic\ObjectServicesGeneric;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class PostRepositoryTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * @var InMemoryDataServicesGeneric
     */
    private $inMemoryDataServices;

    /**
     * @var HydratorServicesGeneric
     */
    private $hydratorServices;


    public function setUp() {

        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();

        $this -> inMemoryDataServices = new InMemoryDataServicesGeneric( new FileServicesGeneric(), new HydratorServicesGeneric( new ObjectServicesGeneric() ));
        $this -> hydratorServices = new HydratorServicesGeneric( new ObjectServicesGeneric() );
    }


    public function testShouldObtainAEntityWhenIdIsAnInteger() {
        $postRepository = new PostRepository( $this -> inMemoryDataServices, $this -> hydratorServices );

        $entities = $postRepository -> findAll( );

        var_dump( $entities );

        $this -> assertInternalType("integer", $entities[0] -> getId() );
    }


    public function testShouldObtainFiveOrBelowEntitiesWithOrderLimit() {

        $orderLimit = new OrderLimit();
        $orderLimit -> setStart(0);
        $orderLimit -> setEnd(5);

        $postRepository = new PostRepository( $this -> inMemoryDataServices, $this -> hydratorServices );

        $entities = $postRepository -> getValidPostWithOrderAndLimit( $orderLimit );

        if( count($entities) >= 0 ) {

            if( count($entities) <= 5 ) {
                $state = true;
            }
            $this -> assertTrue($state);
            $this -> assertInternalType("array",$entities[0]);
        }
        else {
            $this -> assertInternalType("array",$entities);
        }

    }
}
