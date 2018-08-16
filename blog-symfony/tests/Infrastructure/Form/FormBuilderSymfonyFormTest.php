<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:44
 */

namespace App\Tests\Infrastructure\Form;

use App\Infrastructure\Form\FormBuilderSymfonyForm;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class FormBuilderSymfonyFormTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $this -> container = $kernel -> getDic();
    }


    public function testShouldObtainAValidFormVisualisation() {
        $formBuilderSymfony = new FormBuilderSymfonyForm( $this -> container -> get("form.factory") );
        $formBuilderSymfony -> getForm("RegisterUserType");

        $this -> assertInstanceOf("Symfony\Component\Form\FormView",$formBuilderSymfony -> getView() );

    }

    public function testShouldObtainAValidForm() {

        $formBuilderSymfony = new FormBuilderSymfonyForm( $this -> container -> get("form.factory") );
        $this -> assertInstanceOf("\Symfony\Component\Form\FormInterface",$formBuilderSymfony -> getForm("RegisterUserType") );
    }

    public function testShouldObtainAnErrorWhenCreateFormDoesntExist() {
        $this -> expectException("\App\Exception\FormNotFoundException");

        $formBuilderSymfony = new FormBuilderSymfonyForm( $this -> container -> get("form.factory") );
        $formBuilderSymfony -> getForm("UnitTestType");
    }
}
