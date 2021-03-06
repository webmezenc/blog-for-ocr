<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/08/2018
 * Time: 11:15
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue3UseCases;
use App\Domain\UseCases\Issue52UseCases;
use App\Infrastructure\InfrastructureRequestInterface;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Request\RequestFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Utils\Generic\ParametersBag;
use App\Utils\Services\Post\PostServices;
use PHPUnit\Framework\TestCase;

class Issue3UseCasesTest extends TestCase
{

    /**
     * @var PostServices
     */
    private $postServices;

    /**
     * @var InfrastructureRequestInterface
     */
    private $request;

    /**
     * @var Issue52UseCases
     */
    private $issue52UseCases;

    public function setUp() {

        $this -> postServices = $this -> initPostServicesAndIssue52UseCases();
        $this -> request = RequestFactory::create();

    }



    private function initPostServicesAndIssue52UseCases(): PostServices {

        $kernel = KernelFactory::getKernel();

        $repositoryFactory = new RepositoryFactory( $kernel -> getDic() );

        $postRepository = $repositoryFactory -> create("Post","inMemory");
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");
        $this -> issue52UseCases = new Issue52UseCases($commentsRepository);

        return new PostServices( $postRepository );
    }



    public function testWhenPostIsValidObtainPostInformationsInArray() {

        $parameterBag  = new ParametersBag( ["slug" => "blog-is-open"] );

        $issue3UseCases = new Issue3UseCases( $this -> postServices, $this -> request,$parameterBag,$this -> issue52UseCases );

        $this -> assertInternalType( "array", $issue3UseCases -> process() );

    }


    public function testWhenPostIsNotPublishedThenHaveAnUnhautorizedError() {

        $this -> expectException( "\App\Exception\UnhautorizedException");

        $parameterBag  = new ParametersBag( ["slug" => "unittestnotpublished"] );

        $issue3UseCases = new Issue3UseCases( $this -> postServices, $this -> request, $parameterBag,$this -> issue52UseCases );

        $issue3UseCases -> process();
    }


    public function testWhenSlugIsntValidOrDefinedThenHaveErrorNotFound() {

        $this -> expectException("\App\Exception\NotFoundException");

        $parameterBag  = new ParametersBag();


        $issue3UseCases = new Issue3UseCases( $this -> postServices, $this -> request, $parameterBag,$this -> issue52UseCases );

        $issue3UseCases -> process();

    }
}
