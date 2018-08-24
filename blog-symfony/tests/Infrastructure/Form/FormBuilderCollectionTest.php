<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 17/08/2018
 * Time: 14:08
 */

namespace App\Tests\Infrastructure\Form;

use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\InfrastructureFormBuilderInterface;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class FormBuilderCollectionTest extends TestCase
{
    /**
     * @var InfrastructureFormBuilderInterface
     */
    private $formBuilder;

    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $container = $kernel -> getDic();

        $this -> formBuilder = new FormBuilderFactory( $container, new Request() );
    }

    public function testShouldObtainAValidCollection() {
        $UserRegisterForm = $this -> formBuilder -> create("RegisterUserType");
        $FormBuilderCollection = new FormBuilderCollection();
        $FormBuilderCollection -> addForm( $UserRegisterForm );

        $this -> assertInternalType("array", $FormBuilderCollection -> getAllForms() );
    }

    public function testShouldObtainAnErrorWhenFormCollectionIsEmpty() {
        $this -> expectException("\App\Exception\FormCollectionIsEmptyException");

        $FormBuilderCollection = new FormBuilderCollection();
        $FormBuilderCollection -> getAllForms();
    }

    public function testShouldObtainAValidFormBuilder() {
        $UserRegisterForm = $this -> formBuilder -> create("RegisterUserType");
        $FormBuilderCollection = new FormBuilderCollection();
        $FormBuilderCollection -> addForm( $UserRegisterForm );

        $this -> assertInstanceOf("\App\Infrastructure\InfrastructureFormBuilderInterface", $FormBuilderCollection -> getForm( "RegisterUserType") );
    }

    public function testSHouldObtainAnErrorWhenAccessToFormButTheFormIsntInCollection() {
        $this -> expectException("\App\Exception\FormInstanceNotFoundException");

        $FormBuilderCollection = new FormBuilderCollection();
        $FormBuilderCollection -> getForm("unitTest");

    }

    public function testShouldObtainAVoidMethodWhenFormIsAddWithSuccess() {
        $UserRegisterForm = $this -> formBuilder -> create("RegisterUserType");
        $FormBuilderCollection = new FormBuilderCollection();
        $this -> assertNull( $FormBuilderCollection -> addForm( $UserRegisterForm ) );
    }

    public function testShouldObtainErrorWhenFormAlreadyExistInCollection() {
        $this -> expectException("\App\Exception\FormBuilderIsAlreadyInCollectionException");

        $UserRegisterForm = $this -> formBuilder -> create("RegisterUserType");
        $FormBuilderCollection = new FormBuilderCollection();

        $FormBuilderCollection -> addForm( $UserRegisterForm );
        $FormBuilderCollection -> addForm( $UserRegisterForm );
    }
}
