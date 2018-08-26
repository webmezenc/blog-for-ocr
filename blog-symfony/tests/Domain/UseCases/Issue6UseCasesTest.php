<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 24/08/2018
 * Time: 16:45
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue6UseCases;
use App\Entity\DTO\AddCommentDTO;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\InfrastructureFormBuilderCollectionInterface;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class Issue6UseCasesTest extends TestCase
{

    /**
     * @var Issue6UseCases
     */
    private $issue6UseCases;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp() {

        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();

    }

    public function testShouldAddCommentAndCommentIsValid() {

        $formBuilderFactory = new FormBuilderFactory( $this -> container, new Request() );
        $addCommentForm = $formBuilderFactory -> create("AddCommentType");

        $addCommentForm -> submitForm(
            ["content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."]
        );
        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $addCommentForm );

        $addCommentDTO = $this -> getDTO( $formBuilderCollection, "" );

        $issue6UseCases = new Issue6UseCases( $addCommentDTO );

        $dataUseCase = $issue6UseCases -> process();

        $this -> assertEquals("CommentSuccessfullyAdded",$dataUseCase["msg"]);

    }

    public function testShouldAddCommentButCommentIsntValid() {

        $formBuilderFactory = new FormBuilderFactory( $this -> container, new Request() );
        $addCommentForm = $formBuilderFactory -> create("AddCommentType");

        $addCommentForm -> submitForm(
            ["content" => "Contenu de test"]
        );
        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $addCommentForm );

        $addCommentDTO = $this -> getDTO( $formBuilderCollection, "" );

        $issue6UseCases = new Issue6UseCases( $addCommentDTO );

        $dataUseCase = $issue6UseCases -> process();

        $this -> assertArrayHasKey("constraintErrors",$dataUseCase);
    }

    public function testShouldObtainATextzoneToCommentPost() {

        $formBuilderFactory = new FormBuilderFactory( $this -> container, new Request() );
        $addCommentForm = $formBuilderFactory -> create("AddCommentType");
        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $addCommentForm );

        $addCommentDTO = $this -> getDTO( $formBuilderCollection, "" );


        $this -> issue6UseCases = new Issue6UseCases( $addCommentDTO );


        $this -> assertArrayHasKey("form", $this -> issue6UseCases -> process() );
    }





    private function getDTO( InfrastructureFormBuilderCollectionInterface $formbuildercollection, string $slug  ): AddCommentDTO {

        $AddCommentDTO = new AddCommentDTO();
        $AddCommentDTO -> formbuildercollection = $formbuildercollection;
        $AddCommentDTO -> slugPost = $slug;

        $RepositoryFactory = new RepositoryFactory($this -> container);
        $PostRepository = $RepositoryFactory -> create("Post","inMemory");
        $AddCommentDTO -> postRepository = $PostRepository;

        $gatewayAuthenticateUserFactory = new AuthenticateUserFactory( $this -> container );
        $AddCommentDTO -> gatewayAuthenticateUser = $gatewayAuthenticateUserFactory -> create("InMemory");

        return $AddCommentDTO;
    }

}
