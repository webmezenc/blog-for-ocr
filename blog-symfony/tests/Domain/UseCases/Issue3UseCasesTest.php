<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/08/2018
 * Time: 11:15
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue3UseCases;
use App\Infrastructure\InfrastructureRequestInterface;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Request\RequestFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
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



    public function setUp() {

        $this -> postServices = $this -> initPostServices();
        $this -> request = RequestFactory::create();

    }



    private function initPostServices(): PostServices {

        $kernel = KernelFactory::getKernel();

        $repositoryFactory = new RepositoryFactory( $kernel -> getDic() );

        $postRepository = $repositoryFactory -> create("Post");

        return new PostServices( $postRepository );
    }



    public function testWhenPostIsValidObtainPostInformationsInArray() {

        $request = $this -> request;
        $request -> getRequest() -> set("slug","blog-is-open");

        $issue3UseCases = new Issue3UseCases( $this -> postServices, $request );

        $this -> assertInternalType( "array", $issue3UseCases -> process() );

    }


    public function testWhenPostIsNotPublishedThenHaveAnUnhautorizedError() {

        $this -> expectException( "\App\Exception\UnhautorizedException");

        $request = $this -> request;
        $request -> getRequest() -> set("slug","unittestnotpublished");

        $issue3UseCases = new Issue3UseCases( $this -> postServices, $request );

        $issue3UseCases -> process();
    }


    public function testWhenSlugIsntValidOrDefinedThenHaveErrorNotFound() {

        $this -> expectException("\App\Exception\NotFoundException");

        $issue3UseCases = new Issue3UseCases( $this -> postServices, $this -> request );

        $issue3UseCases -> process();

    }
}
