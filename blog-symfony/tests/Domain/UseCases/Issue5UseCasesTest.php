<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 22/08/2018
 * Time: 14:05
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue5UseCases;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\InfrastructureRepositoryFactoryInterface;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;


class Issue5UseCasesTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var InfrastructureRepositoryFactoryInterface
     */
    private $userRepository;


    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();

        $RepositoryFactory = new RepositoryFactory( $this -> container );
        $this -> userRepository = $RepositoryFactory -> create("User","inMemory");
    }

    public function testShouldIdentifyUserWhenUserIndentificationInformationsIsValid() {
        $formBuilderFactory = new FormBuilderFactory( $this -> container, new Request() );
        $LoginForm = $formBuilderFactory -> create("LoginType");
        $LoginForm -> submitForm(["email" => "contact@webmezenc.com","password" => "test"]);

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $LoginForm );

        $issue5UseCases = new Issue5UseCases($formBuilderCollection,$this -> userRepository);
        $arrData = $issue5UseCases -> process();

        $this -> assertArrayHasKey("msg",$arrData );
        $this -> assertEquals("userLoginInformationsIsValid",$arrData["msg"]);

    }

    public function testShouldIdentifyUserButUserIdentificationParametersIsntValid() {

        $formBuilderFactory = new FormBuilderFactory( $this -> container, new Request() );
        $LoginForm = $formBuilderFactory -> create("LoginType");
        $LoginForm -> submitForm(["email" => "contact@webmezenc.com","password" => "essai"]);

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $LoginForm );

        $issue5UseCases = new Issue5UseCases($formBuilderCollection,$this -> userRepository);
        $arrData = $issue5UseCases -> process();

        $this -> assertArrayHasKey("msg",$arrData );
        $this -> assertEquals("userLoginInformationsIsntValid",$arrData["msg"]);

    }


    public function testShouldObtainALoginFormWhenUserIsntConnected() {

        $formBuilderFactory = new FormBuilderFactory( $this -> container, new Request() );
        $LoginForm = $formBuilderFactory -> create("LoginType");

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $LoginForm );

        $issue5UseCases = new Issue5UseCases($formBuilderCollection,$this -> userRepository);

        $this -> assertArrayHasKey("form",$issue5UseCases -> process() );
    }
}
