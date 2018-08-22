<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 21/08/2018
 * Time: 16:34
 */

namespace App\Tests\Infrastructure\Render;

use App\Infrastructure\Render\RenderFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class RenderFactoryTest extends TestCase
{

    /**
     * @var RenderFactory
     */
    private $renderFactory;

    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $this -> renderFactory = new RenderFactory( $kernel -> getDic() );
    }

    public function testShouldObtainTwigRenderAndRenderIsValid() {
        $render = $this -> renderFactory -> create("Twig");
        $this -> assertInstanceOf( "\App\Infrastructure\InfrastructureRenderInterface",$render);
    }

    public function testShouldObtainRenderButRenderIsntSupported() {
        $this -> expectException("\App\Exception\InfrastructureAdapterException");

        $this -> renderFactory -> create("unittest");
    }
}
