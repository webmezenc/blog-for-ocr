<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 24/08/2018
 * Time: 16:45
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\Command\Comment\AddCommentWithUserAndPost;
use App\Domain\UseCases\Issue6UseCases;
use App\Entity\DTO\AddCommentDTO;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\InfrastructureFormBuilderCollectionInterface;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Tests\TestsUtils\Entity\AddCommentDTOEntity;
use App\Utils\Services\Comment\CommentServices;
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


    /**
     * @var AddCommentWithUserAndPost
     */
    private $AddCommentWithUserAndPost;

    public function setUp() {

        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();

        $authenticateUserFactory = new AuthenticateUserFactory($this -> container);
        $gatewayAuthenticateUser = $authenticateUserFactory -> create("inMemory");

        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();

        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");
        $postRepository = $repositoryFactory -> create("Post","inMemory");
        $commentsServices = new CommentServices($validator,$commentsRepository);

        $this -> AddCommentWithUserAndPost = new AddCommentWithUserAndPost($gatewayAuthenticateUser,$postRepository,$commentsServices );


    }

    public function testShouldAddCommentAndCommentIsValid() {

        $formBuilderFactory = new FormBuilderFactory( $this -> container, new Request() );
        $addCommentForm = $formBuilderFactory -> create("AddCommentType");

        $addCommentForm -> submitForm(
            ["content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."]
        );
        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $addCommentForm );

        $addCommentDTO = AddCommentDTOEntity::getDTO($this -> container, $formBuilderCollection, "" );
        $addCommentDTO -> slugPost = "post-test";

        $issue6UseCases = new Issue6UseCases( $addCommentDTO,$this -> AddCommentWithUserAndPost  );

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

        $addCommentDTO = AddCommentDTOEntity::getDTO($this -> container, $formBuilderCollection, "" );

        $issue6UseCases = new Issue6UseCases( $addCommentDTO,$this -> AddCommentWithUserAndPost  );

        $dataUseCase = $issue6UseCases -> process();

        $this -> assertArrayHasKey("constraintErrors",$dataUseCase);
    }

    public function testShouldObtainATextzoneToCommentPost() {

        $formBuilderFactory = new FormBuilderFactory( $this -> container, new Request() );

        $addCommentForm = $formBuilderFactory -> create("AddCommentType");
        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $addCommentForm );

        $addCommentDTO = AddCommentDTOEntity::getDTO($this -> container, $formBuilderCollection, "" );


        $this -> issue6UseCases = new Issue6UseCases( $addCommentDTO,$this -> AddCommentWithUserAndPost  );


        $this -> assertArrayHasKey("form", $this -> issue6UseCases -> process() );
    }





}
