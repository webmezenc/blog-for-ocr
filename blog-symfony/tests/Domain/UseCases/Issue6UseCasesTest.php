<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 24/08/2018
 * Time: 16:45
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue6UseCases;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class Issue6UseCasesTest extends TestCase
{

    /**
     * @var Issue6UseCases
     */
    private $issue6UseCases;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp() {

        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();

    }

    public function testShouldObtainATextzoneToCommentPost() {

        $formBuilderFactory = new FormBuilderFactory( $this -> container, new Request() );
        $addCommentForm = $formBuilderFactory -> create("AddCommentType");


        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $addCommentForm );

        $this -> issue6UseCases = new Issue6UseCases( $formBuilderCollection );


        $this -> assertArrayHasKey("form", $this -> issue6UseCases -> process() );
    }

}
