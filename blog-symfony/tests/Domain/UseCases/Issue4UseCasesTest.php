<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:14
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue4UseCases;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Tests\Infrastructure\Kernel\SymfonyKernel;
use App\Utils\Services\User\UserServices;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class Issue4UseCasesTest extends TestCase
{

    /**
     * @var FormBuilderCollection
     */
    private $formBuilderCollection;

    /**
     * @var SymfonyKernel
     */
    private $kernel;

    /**
     * @var UserServices
     */
    private $userServices;

    /**
     * @var ContainerInterface
     */
    private $container;



    /**
     * @throws \App\Exception\FormBuilderIsAlreadyInCollectionException
     * @throws \App\Exception\FormNotFoundException
     */

    public function setUp() {
        $this -> kernel = KernelFactory::getKernel();
        $this -> container = $this -> kernel -> getDic();

        $repositoryFactory = new RepositoryFactory( $this -> kernel -> getDic() );
        $userRepository = $repositoryFactory -> create("User","inMemory");
        $this -> userServices = new UserServices( $userRepository );


        $formFactory = new FormBuilderFactory( $this -> kernel -> getDic(), $this -> getRequestError() );


        $RegisterUserForm = $formFactory -> create("RegisterUserType");

        $this -> formBuilderCollection = new FormBuilderCollection();
        $this -> formBuilderCollection -> addForm( $RegisterUserForm );

    }


    public function testShouldVerifyUserAndUserIsRegistrable() {

        $this -> formBuilderCollection -> getForm("RegisterUserType") -> submitForm(
            [
                "firstname" => "unit",
                "lastname" => "test",
                "email" => "contactunittestregister@webmezenc.com",
                "password" => "test"
            ]
        );


        $issue4UseCases = new Issue4UseCases( $this -> formBuilderCollection, $this -> userServices );
        $arrDataUseCase = $issue4UseCases -> process();

        $this -> assertEquals(Issue4UseCases::SUCCESSFULL_REGISTERED,$arrDataUseCase["msgRegisterUser"]);

    }


    public function testShouldVerifyUserAndUserIsAlreadyRegistredWhenFormIsSubmittedAndValid() {


        $this -> formBuilderCollection -> getForm("RegisterUserType") -> submitForm(
            [
                "firstname" => "unit",
                "lastname" => "test",
                "email" => "contact@webmezenc.com",
                "password" => "test"
            ]
        );


        $issue4UseCases = new Issue4UseCases( $this -> formBuilderCollection, $this -> userServices );
        $arrDataUseCase = $issue4UseCases -> process();

        $this -> assertArrayHasKey("msgRegisterUser", $arrDataUseCase );
        $this -> assertEquals(Issue4UseCases::ALREADY_REGISTRED,$arrDataUseCase["msgRegisterUser"]);
    }


    public function testShouldDisplayFormWhenFormIsSubmitedButInvalid() {

        $this -> formBuilderCollection -> getForm("RegisterUserType") -> submitForm(
            [
                "firstname" => "unit",
                "lastname" => "test"
            ]
        );

        $issue4UseCases = new Issue4UseCases( $this -> formBuilderCollection, $this -> userServices  );
        $arrDataUseCase = $issue4UseCases -> process();

        $this -> assertArrayHasKey("view", $arrDataUseCase );
        $this -> assertEquals(Issue4UseCases::FORM_IS_INVALID,$arrDataUseCase["msgRegisterUser"]);
    }

    public function testShouldDisplayFormWhenUserIsntRegistred() {

        $issue4UseCases = new Issue4UseCases( $this -> formBuilderCollection, $this -> userServices  );
        $arrDataUseCase = $issue4UseCases -> process();

        $this -> assertArrayHasKey("view", $arrDataUseCase );
    }

    private function getRequestError(): Request {
        $Request = new Request();
        $Request -> request -> set("firstname","unit");
        $Request -> request -> set("lastname","test");
        return $Request;
    }
}
