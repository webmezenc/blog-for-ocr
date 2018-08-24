<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:44
 */

namespace App\Tests\Infrastructure\Form;

use App\Infrastructure\Form\FormBuilderSymfonyFormBuilder;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

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

    public function testShouldObtainAValidErrors() {
        $formBuilderSymfony = new FormBuilderSymfonyFormBuilder("RegisterUserType", $this -> container -> get("form.factory"), new Request() );
        $Form = $formBuilderSymfony -> getForm();

        $this -> assertInstanceOf("\Symfony\Component\Form\FormErrorIterator", $formBuilderSymfony -> getErrors() );
    }


    public function testShouldObtainAValidFormVisualisation() {
        $formBuilderSymfony = new FormBuilderSymfonyFormBuilder("RegisterUserType", $this -> container -> get("form.factory"), new Request()  );
        $Form = $formBuilderSymfony -> getForm();

        $this -> assertInstanceOf("Symfony\Component\Form\FormView",$formBuilderSymfony -> getView() );

    }

    public function testShouldObtainAValidForm() {

        $formBuilderSymfony = new FormBuilderSymfonyFormBuilder("RegisterUserType", $this -> container -> get("form.factory"), new Request()  );
        $this -> assertInstanceOf("\Symfony\Component\Form\FormInterface",$formBuilderSymfony -> getForm() );
    }

    public function testShouldObtainAnErrorWhenCreateFormDoesntExist() {
        $this -> expectException("\App\Exception\FormNotFoundException");

        $formBuilderSymfony = new FormBuilderSymfonyFormBuilder("UnitTestType", $this -> container -> get("form.factory"), new Request()  );
        $formBuilderSymfony -> getForm();
    }
}
