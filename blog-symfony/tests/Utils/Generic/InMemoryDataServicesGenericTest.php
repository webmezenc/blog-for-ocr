<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/08/2018
 * Time: 11:50
 */

namespace App\Tests\Utils\Generic;

use App\Utils\Generic\FileServicesGeneric;
use App\Utils\Generic\HydratorServicesGeneric;
use App\Utils\Generic\InMemoryDataServicesGeneric;
use App\Utils\Generic\ObjectServicesGeneric;
use PHPUnit\Framework\TestCase;

class InMemoryDataServicesGenericTest extends TestCase
{

    private $inMemoryDataServices;

    public function setUp() {

        $this -> inMemoryDataServices = new InMemoryDataServicesGeneric( new FileServicesGeneric(), new HydratorServicesGeneric( new ObjectServicesGeneric() ));
    }


    public function testWhenDeleteTuppleWithValidId() {

        $tupplesData = $this -> inMemoryDataServices -> getDataForEntity("Post");
        $tupplesData = $this -> inMemoryDataServices -> deleteTuppleWithId( 26, $tupplesData );

        $this -> assertEquals( 24, count($tupplesData) );
    }

    public function testWhenDeleteTuppleWithIdButIdIsntValid() {

        $this -> expectException("\App\Exception\EntityNotFoundException");

        $tupplesData = $this -> inMemoryDataServices -> getDataForEntity("Post");

        $this -> inMemoryDataServices -> deleteTuppleWithId( 27, $tupplesData );

    }

    public function testWhenAddTuppleWithAutoIncrementId() {

        $tupplesData = $this -> inMemoryDataServices -> getDataForEntity("Post");

        $post = [
            "id_post_category_id" => 1,
            "id_user_id" => 1,
            "state" => 1,
            "date_create" => "2018-07-26 15:58:22",
            "date_update" => null,
            "slug" => "post25",
            "title" => "Post test",
            "headcontent" => "head test",
            "content" => "Post test"
        ];

        $tupplesData = $this -> inMemoryDataServices -> addDataInTuppleWithAutoIncrement( $post, $tupplesData );

        end( $tupplesData );
        $current = current($tupplesData);

        $this -> assertEquals(27, $current["id"] );

    }

    public function testWhenAddTuppleWithAutoIncrementIdButAnErrorHasOccurred() {

        $this -> expectException("\App\Exception\ParameterIsNotFoundException");

        $post = [
            "id_post_category_id" => 1,
            "id_user_id" => 1,
            "state" => 1,
            "date_create" => "2018-07-26 15:58:22",
            "date_update" => null,
            "slug" => "post25",
            "title" => "Post test",
            "headcontent" => "head test",
            "content" => "Post test"
        ];
        $tupplePost = [ $post ];

        $this -> inMemoryDataServices -> addDataInTuppleWithAutoIncrement( $post, $tupplePost );
    }

    public function testWhenAddTupple() {

        $tupplesData = $this -> inMemoryDataServices -> getDataForEntity("Post");

        $post = [
            "id_post_category_id" => 1,
            "id_user_id" => 1,
            "state" => 1,
            "date_create" => "2018-07-26 15:58:22",
            "date_update" => null,
            "slug" => "post25",
            "title" => "Post test",
            "headcontent" => "head test",
            "content" => "Post test"
        ];

        $tupplesData = $this -> inMemoryDataServices -> addDataInTuppleWithAutoIncrement( $post,$tupplesData );


        $this -> assertEquals(26, count($tupplesData) );
    }

    public function testShouldFileIsCorrectlyOpenedAndValidJson() {
        $this -> assertInternalType("array", $this -> inMemoryDataServices -> getDataForEntity("Post") );
    }

    public function testShouldFileISCorrectlyOpenedButIsInvalidJson() {
        $this -> expectException("\App\Exception\FileIsNotValidJsonException");

        $this -> inMemoryDataServices -> getDataForEntity( "TestFileIsNotValidJson" );
    }

    public function testShouldFileIsCorrectlyOpenedButIsEmpty() {
        $this -> expectException("\App\Exception\FileEmptyException");

        $this -> inMemoryDataServices -> getDataForEntity( "TestFileEmpty" );
    }

    public function testTheFileIsntFound() {

        $this -> expectException("\App\Exception\FileNotFoundException");

        $this -> inMemoryDataServices -> getDataForEntity( "Test" );
    }
}
