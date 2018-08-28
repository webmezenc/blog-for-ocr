<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 28/08/2018
 * Time: 11:50
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue8UseCases;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\Mailer\MailerFactory;
use App\Infrastructure\Render\RenderFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Utils\Generic\ParametersBag;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class Issue8UseCasesTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;


    public function setUp() {

        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();

    }

    public function testWhenFormIsSubmitAndSubmitIsValid() {

        $formBuilderFactory = new FormBuilderFactory($this->container, new Request());
        $contactAdministratorForm = $formBuilderFactory -> create("ContactAdministratorType");
        $contactAdministratorForm -> submitForm(
            [
                "email" => "contact@webmezenc.com",
                "subject" => "Sujet de test",
                "message" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."
            ]
        );
        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $contactAdministratorForm );

        $mailerFactory = new MailerFactory($this -> container);
        $mailer = $mailerFactory -> create("Logger");

        $renderFactory = new RenderFactory($this -> container);
        $render = $renderFactory -> create();
        $parameterBag = new ParametersBag();
        $parameterBag -> add( ["email_administrator" => "contact@webmezenc.com"] );

        $issue8UseCases = new Issue8UseCases($formBuilderCollection, $parameterBag,$mailer,$render);
        $arrData = $issue8UseCases -> process();

        $this -> assertEquals("msgSentSuccess",$arrData["msg"]);
    }

    public function testWhenFormIsSubmitAndSubmitIsValidButEmailAdministratorIsntDefinedInOptions() {

        $this -> expectException("\App\Exception\ParameterIsNotFoundException");

        $formBuilderFactory = new FormBuilderFactory($this->container, new Request());
        $contactAdministratorForm = $formBuilderFactory -> create("ContactAdministratorType");
        $contactAdministratorForm -> submitForm(
            [
                "email" => "contact@webmezenc.com",
                "subject" => "Sujet de test",
                "message" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."
            ]
        );
        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $contactAdministratorForm );

        $mailerFactory = new MailerFactory($this -> container);
        $mailer = $mailerFactory -> create("Logger");

        $renderFactory = new RenderFactory($this -> container);
        $render = $renderFactory -> create();

        $issue8UseCases = new Issue8UseCases($formBuilderCollection, new ParametersBag(),$mailer,$render);
        $arrData = $issue8UseCases -> process();

    }

    public function testWhenFormIsSubmitButInvalid() {
        $formBuilderFactory = new FormBuilderFactory($this->container, new Request());
        $contactAdministratorForm = $formBuilderFactory -> create("ContactAdministratorType");

        $contactAdministratorForm -> submitForm(
            [
                "email" => "contact@webmezenc.com",
                "subject" => "Sujet de test"
            ]
        );

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $contactAdministratorForm );


        $mailerFactory = new MailerFactory($this -> container);
        $mailer = $mailerFactory -> create("Logger");

        $renderFactory = new RenderFactory($this -> container);
        $render = $renderFactory -> create();

        $issue8UseCases = new Issue8UseCases($formBuilderCollection, new ParametersBag(),$mailer,$render);
        $arrData = $issue8UseCases -> process();

        $this -> assertArrayHasKey("form",$arrData);
        $this -> assertEquals("formIsInvalid",$arrData["msg"]);
    }

    public function testShouldObtainAFormToContactAdministrator() {

        $formBuilderFactory = new FormBuilderFactory($this->container, new Request());
        $contactAdministratorForm = $formBuilderFactory -> create("ContactAdministratorType");

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $contactAdministratorForm );

        $mailerFactory = new MailerFactory($this -> container);
        $mailer = $mailerFactory -> create("Logger");

        $renderFactory = new RenderFactory($this -> container);
        $render = $renderFactory -> create();

        $issue8UseCases = new Issue8UseCases($formBuilderCollection, new ParametersBag(),$mailer,$render);

        $this -> assertArrayHasKey("form",$issue8UseCases -> process());

    }
}
