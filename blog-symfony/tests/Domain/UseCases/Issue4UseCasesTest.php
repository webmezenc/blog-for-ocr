<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:14
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue4UseCases;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Tests\Infrastructure\Kernel\SymfonyKernel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class Issue4UseCasesTest extends TestCase
{

    /**
     * @var FormBuilderFactory
     */
    private $formFactory;

    /**
     * @var SymfonyKernel
     */
    private $kernel;

    public function setUp() {
        $this -> kernel = KernelFactory::getKernel();

    }

    public function testShouldDisplayFormWhenFormIsSubmitedButInvalid() {
        $formFactory = new FormBuilderFactory( $this -> kernel -> getDic(), $this -> getRequestError() );
        $issue4UseCases = new Issue4UseCases( $formFactory -> create() );
        $arrDataUseCase = $issue4UseCases -> process();

        $this -> assertArrayHasKey("view", $arrDataUseCase );
        $this -> assertArrayHasKey("formError",$arrDataUseCase);
    }

    public function testShouldDisplayFormWhenUserIsntRegistred() {

        $formFactory = new FormBuilderFactory( $this -> kernel -> getDic(), new Request() );
        $issue4UseCases = new Issue4UseCases( $formFactory-> create() );
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
