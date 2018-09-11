<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 27/08/2018
 * Time: 12:35
 */

namespace App\Tests\Domain\Command\Comment;

use App\Domain\Command\Comment\AddCommentWithUserAndPost;
use App\Entity\Comments;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Utils\Services\Comment\CommentServices;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\ValidatorBuilder;

class AddCommentWithUserAndPostTest extends TestCase
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var AddCommentWithUserAndPost
     */
    private $addCommentWithUserAndPost;

    public function setUp() {

        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();

        $authenticateUserFactory = new AuthenticateUserFactory($this -> container);
        $gatewayAuthenticateUser = $authenticateUserFactory -> create("inMemory");

        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post","inMemory");
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");


        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();
        $commentServices = new CommentServices($validator,$commentsRepository);

        $this -> addCommentWithUserAndPost = new AddCommentWithUserAndPost( $gatewayAuthenticateUser, $postRepository, $commentServices );

    }


    public function testShouldAddCommentndAddCommentIsASuccess() {
        $comments = new Comments();
        $comments -> setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
        $this -> assertTrue( $this -> addCommentWithUserAndPost -> addComment("post-test", $comments ) );

    }

    public function testShouldAddPostButSlugIsntValid() {
        $this -> expectException("\App\Exception\EntityNotFoundException");
        $this -> addCommentWithUserAndPost -> addComment("unit-test", new Comments() );
    }


}
