<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 17/08/2018
 * Time: 10:00
 */

namespace App\Tests\Infrastructure\Form;

use App\Infrastructure\Form\FormBuilderFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class FormBuilderFactoryTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $this -> container = $kernel -> getDic();

    }


    public function testShouldObtainAValidFormBuilder() {
        $formBuilderFactory = new FormBuilderFactory( $this -> container, new Request() );
        $this -> assertInstanceOf("\App\Infrastructure\InfrastructureFormBuilderInterface", $formBuilderFactory -> create("FormBuilderSymfony") );
    }

    public function testShouldObtainAnErrorWhenFormBuilderIsntExist() {
        $this -> expectException("\App\Exception\FormNotFoundException");

        $formBuilderFactory = new FormBuilderFactory( $this -> container, new Request() );
        $formBuilderFactory -> create("unitTest");
    }
}
