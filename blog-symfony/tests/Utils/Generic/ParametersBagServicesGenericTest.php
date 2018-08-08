<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 08/08/2018
 * Time: 19:05
 */

namespace App\Tests\Utils\Generic;

use App\Utils\Generic\ParametersBag;
use App\Utils\Generic\ParametersBagInterface;
use PHPUnit\Framework\TestCase;

class ParametersBagServicesGenericTest extends TestCase
{
    /**
     * @var ParametersBagInterface
     */
    private $parameterBag;

    public function setUp() {
        $parameters = ["test" => "unit"];
        $this -> parameterBag = new ParametersBag( $parameters );
    }

    public function testWhenAllParametersIsValidArray() {

        $this -> assertInternalType("array",$this -> parameterBag -> all() );
    }
}
