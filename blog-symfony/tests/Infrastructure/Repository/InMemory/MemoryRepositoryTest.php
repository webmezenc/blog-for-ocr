<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 13/08/2018
 * Time: 11:09
 */

namespace App\Tests\Infrastructure\Repository\InMemory;

use App\Repository\InMemory\MemoryRepository;
use App\Utils\Generic\FileServicesGeneric;
use App\Utils\Generic\InMemoryDataServicesGeneric;
use PHPUnit\Framework\TestCase;

class MemoryRepositoryTest extends TestCase
{

    private $memoryRepository;

    public function setUp() {
        $fileServicesGeneric = new FileServicesGeneric();
        $this -> memoryRepository = new MemoryRepository( new InMemoryDataServicesGeneric($fileServicesGeneric) , "User");
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


    public function testShouldObtainErrorWhenEntityIsntValidEntity() {

        $this -> expectException("\App\Exception\FileNotFoundException");

        $fileServicesGeneric = new FileServicesGeneric();
        $memoryRepository = new MemoryRepository( new InMemoryDataServicesGeneric($fileServicesGeneric) , "UnitTestFalseEntity");


    }
}
