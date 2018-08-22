<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 21/08/2018
 * Time: 15:55
 */

namespace App\Tests\Infrastructure\Render;

use App\Infrastructure\InfrastructureRenderInterface;
use App\Infrastructure\Render\TwigRender;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class TwigRenderTest extends TestCase
{
    /**
     * @var InfrastructureRenderInterface
     */
    private $twigRender;

    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $container = $kernel -> getDic();
        $this -> twigRender = new TwigRender( $container -> get("twig") );
    }

    public function testShouldRenderViewAndViewIsCorrectlyRender() {
        $this -> assertEquals("Unit test", $this -> twigRender -> renderView("debug/unittest.html.twig", ["debug" => "test"] ) );
    }

    public function testShouldRenderViewButViewContainErrorParams() {
        $this -> expectException("\App\Exception\ViewSyntaxErrorException");

        $this -> twigRender -> renderView("debug/unittesterrorsyntax.html.twig");
    }

    public function testShouldRenderViewButTemplateContainParamsNotDefined() {
        $this -> expectException("\App\Exception\ViewParamsUndefinedException");

        $this -> twigRender -> renderView("debug/unittesterrorparams.html.twig" );
    }

    public function testShouldRenderViewButViewIsNotFound() {
        $this -> expectException("\App\Exception\ViewNotFoundException");

        $this -> twigRender -> renderView("unitTestNotFound" );
    }
}
