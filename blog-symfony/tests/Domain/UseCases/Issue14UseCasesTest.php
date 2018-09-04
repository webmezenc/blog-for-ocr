<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 30/08/2018
 * Time: 16:57
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\Command\Post\AddPostWithActualUser;
use App\Domain\UseCases\Issue14UseCases;
use App\Entity\PostCategory;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\GatewayAuthenticateUser;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class Issue14UseCasesTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * @var GatewayAuthenticateUser
     */
    private $authenticateUserGateway;


    /**
     * @var string
     */
    private $formBuilderName;


    /**
     * @var AddPostWithActualUser
     */
    private $addPostWithActualUser;


    /**
     * @throws \App\Exception\InfrastructureAdapterException
     */

    public function setUp() {
        $kernel = KernelFactory::getKernel();
        $this -> container = $kernel -> getDic();

        $this -> formBuilderName = $this -> container -> getParameter("formBuilderProvider");

        $authenticateUserFactory = new AuthenticateUserFactory( $this -> container );
        $this -> authenticateUserGateway = $authenticateUserFactory -> create("inMemory");

        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();
        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");
        $this -> addPostWithActualUser = new AddPostWithActualUser($validator,$this -> authenticateUserGateway,$postRepository);
    }


    public function testShouldObtainASuccess() {

        $repositoryFactory = new RepositoryFactory($this -> container );
        $postCategoryRepository = $repositoryFactory -> create("PostCategory","inMemory");

        $postCategory = $postCategoryRepository -> findAll();

        $formFactory = new FormBuilderFactory( $this -> container, new Request() );
        $addPostType = $formFactory -> create("AddPostType", $this -> formBuilderName, ["attr" => ["postcategory" =>$postCategory]]);
        $addPostType -> submitForm( [
            "title" => "Unit test essai",
            "headcontent" => "Lorem ipsum dolor sit amet, consectetur",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
            "id_post_category" => 1,
            "state" => 0
            ] );

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $addPostType );
        $issue14UseCases = new Issue14UseCases($formBuilderCollection,$this -> authenticateUserGateway,$this -> addPostWithActualUser);

        $dataProcess = $issue14UseCases -> process();

        $this -> assertArrayHasKey("msg",$dataProcess );
        $this -> assertEquals( "formAddedSuccessfull", $dataProcess["msg"] );

    }

    public function testShouldObtainErrorWhenChoiceCategoryIsntDefined() {
        $this -> expectException("\App\Exception\ParameterIsNotFoundException");

        $formFactory = new FormBuilderFactory( $this -> container, new Request() );
        $formFactory -> create("AddPostType");
    }

    public function testShouldObtainAFormAndErrorWhenFormIsSubmitButRequiredInputIsEmpty() {
        $formFactory = new FormBuilderFactory( $this -> container, new Request() );
        $addPostType = $formFactory -> create("AddPostType", $this -> formBuilderName, ["attr" => ["postcategory" => array()]] );
        $addPostType -> submitForm( ["title" => "Essai"] );

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $addPostType );
        $issue14UseCases = new Issue14UseCases($formBuilderCollection,$this -> authenticateUserGateway,$this -> addPostWithActualUser);

        $dataProcess = $issue14UseCases -> process();

        $this -> assertArrayHasKey("form", $dataProcess );
        $this -> assertArrayHasKey("msg",$dataProcess );
        $this -> assertEquals( "formIsInvalid", $dataProcess["msg"] );
    }

    public function testShouldObtainAFormWhenFormIsntSubmit() {
        $formFactory = new FormBuilderFactory( $this -> container, new Request() );
        $addPostType = $formFactory -> create("AddPostType", $this -> formBuilderName, [ "attr" => ["postcategory" => array()]] );

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $addPostType );
        $issue14UseCases = new Issue14UseCases($formBuilderCollection,$this -> authenticateUserGateway,$this -> addPostWithActualUser);

        $this -> assertArrayHasKey("form", $issue14UseCases -> process() );

    }
}
