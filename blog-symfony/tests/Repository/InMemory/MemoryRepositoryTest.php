<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 13/08/2018
 * Time: 11:09
 */

namespace App\Tests\Infrastructure\Repository\InMemory;

use App\Entity\User;
use App\Repository\InMemory\MemoryRepository;
use App\Utils\Generic\FileServicesGeneric;
use App\Utils\Generic\HydratorServicesGeneric;
use App\Utils\Generic\InMemoryDataServicesGeneric;
use App\Utils\Generic\ObjectServicesGeneric;
use PHPUnit\Framework\TestCase;

class MemoryRepositoryTest extends TestCase
{

    private $memoryRepository;

    public function setUp() {
        $fileServicesGeneric = new FileServicesGeneric();
        $this -> memoryRepository = new MemoryRepository( new InMemoryDataServicesGeneric($fileServicesGeneric, new HydratorServicesGeneric( new ObjectServicesGeneric() )) , new HydratorServicesGeneric( new ObjectServicesGeneric() ), "User");
    }


    public function testShouldObtainAListOfEntityWhenFindAll() {

        $allEntities = $this -> memoryRepository -> findAll();

        $this -> assertInternalType("array",$allEntities);
        $this -> assertInternalType("object",$allEntities[0]);
    }

    public function testShouldObtainValidUserEntityWithFindOneByMethod() {
        $user = $this -> memoryRepository -> findOneBy( array("email" => "contact@webmezenc.com") );
        $this -> assertInstanceOf("\App\Entity\User", $user );
    }

    public function testWhenAddEntityButEntityIsntAValidInsance() {
        $this -> expectException("\App\Exception\EntityNotValidException");

        $this -> memoryRepository -> persist( new \stdClass() );
    }

    public function testShouldAddEntity() {

        $User = new User();
        $User -> setEmail("essai@unittest.com");
        $User -> setState(1);
        $User -> setFirstname("Unit");
        $User -> setLastname("Test");
        $User -> setLevel(0);
        $User -> setPassword("test");

        $this -> memoryRepository -> persist( $User );

        $this -> assertInstanceOf("\App\Entity\User", $this -> memoryRepository -> find(3));
    }

    public function testShouldObtainAValidUserEntityWithUserExist() {

        $user = $this -> memoryRepository -> find( 1 );

        $this -> assertInstanceOf("\App\Entity\User", $user );
        $this -> assertEquals( "contact@webmezenc.com", $user -> getEmail() );

    }

    public function testShouldObtainAnEntityNotFoundWithinFind() {

        $this -> expectException( "\App\Exception\EntityNotFoundException" );

        $this -> memoryRepository -> find( 15 );
    }

    public function testShouldObtainValidEntitiesWhenSearchWithTwoParameters() {

        $searchUser = $this -> memoryRepository -> findBy( array("email" => "contact@webmezenc.com", "lastname" => "Test") );

        $this -> assertEquals(2, count($searchUser) );

    }

    public function testShouldObtainAValidEntityWhenSearchWithOneParameter() {

        $searchUser = $this -> memoryRepository -> findBy( array("email" => "contact@webmezenc.com") );

        $this -> assertInternalType("array", $searchUser);

    }

    public function testShouldSearchEntityButSearchIsAFailure() {

        $searchUser = $this -> memoryRepository -> findBy( array("email" => "unittest@unit.com") );

        $this -> assertNull($searchUser);

    }

    public function testShouldObtainErrorWhenEntityIsntValidEntity() {

        $this -> expectException("\App\Exception\FileNotFoundException");

        $fileServicesGeneric = new FileServicesGeneric();
        $memoryRepository = new MemoryRepository( new InMemoryDataServicesGeneric($fileServicesGeneric,new HydratorServicesGeneric( new ObjectServicesGeneric() )) , new HydratorServicesGeneric( new ObjectServicesGeneric() ),"UnitTestFalseEntity");

    }
}
