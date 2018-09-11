<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/09/2018
 * Time: 15:44
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\Command\Post\EditPostWithActualUser;
use App\Domain\UseCases\Issue35UseCases;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\Repository\RepositoryCollection;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Utils\Generic\ParametersBag;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class Issue35UseCasesTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }

    public function testShouldObtainASuccessMessageWhenPostIsEdited() {

        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");
        $post = $postRepository -> find(1);

        $formBuilderFactory = new FormBuilderFactory($this -> container, new Request() );
        $formBuilderFactory -> setEntityToFill($post);
        $addOrEditPostType = $formBuilderFactory -> create("AddOrEditPostType",
            FormBuilderFactory::DEFAULT_BUILDER, [
                "postcategory" => $this -> getPostCategory()
            ]);

        $addOrEditPostType -> submitForm( [
            "title" => "Unit test essai",
            "headcontent" => "Lorem ipsum dolor sit amet, consectetur",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
            "id_post_category" => 1,
            "state" => 0
        ] );

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm($addOrEditPostType);

        $issue35UseCases = new Issue35UseCases($formBuilderCollection,$this -> getEditPostWithActualUser());
        $dataProcess = $issue35UseCases -> process();

        $this -> assertArrayHasKey("msg",$dataProcess);
        $this -> assertEquals("postIsSuccessfullEdited",$dataProcess["msg"]);
    }

    public function testShouldObtainAnErrorWhenFormIsSubmittedButInvalid() {
        $formBuilderFactory = new FormBuilderFactory($this -> container, new Request() );
        $addOrEditPostType = $formBuilderFactory -> create("AddOrEditPostType",
            FormBuilderFactory::DEFAULT_BUILDER, [
                "postcategory" => $this -> getPostCategory()
            ]);

        $addOrEditPostType -> submitForm(
            ["content" => "test"]
        );

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm($addOrEditPostType);

        $issue35UseCases = new Issue35UseCases($formBuilderCollection,$this -> getEditPostWithActualUser());
        $dataProcess = $issue35UseCases -> process();

        $this -> assertArrayHasKey("msg",$dataProcess);
        $this -> assertEquals("formIsInvalid",$dataProcess["msg"]);

    }

    public function testShouldObtainAnEditForm() {

        $formBuilderFactory = new FormBuilderFactory($this -> container, new Request() );
        $addOrEditPostType = $formBuilderFactory -> create("AddOrEditPostType",
            FormBuilderFactory::DEFAULT_BUILDER, [
                "postcategory" => $this -> getPostCategory()
            ]);

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm($addOrEditPostType);

        $issue35UseCases = new Issue35UseCases($formBuilderCollection,$this -> getEditPostWithActualUser());
        $dataProcess = $issue35UseCases -> process();

        $this -> assertArrayHasKey("form",$dataProcess);
    }


    private function getEditPostWithActualUser() {
        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();

        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");

        $authenticateUserFactory = new AuthenticateUserFactory($this -> container);
        $gatewayAuthenticateUser = $authenticateUserFactory -> create("inMemory");

        return new EditPostWithActualUser($validator,$gatewayAuthenticateUser, $postRepository);
    }

    private function getPostCategory() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        return $repositoryFactory -> create("PostCategory","inMemory") -> findAll();
    }

}
