<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 24/08/2018
 * Time: 19:18
 */

namespace App\Tests\Utils\Services\Comment;

use App\Entity\Comments;
use App\Entity\Post;
use App\Entity\User;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use App\Utils\Services\Comment\CommentServices;
use PHPUnit\Framework\TestCase;

class CommentServicesTest extends TestCase
{

    /**
     * @var CommentServices
     */
    private $commentServices;

    /**
     * @throws \App\Exception\InfrastructureAdapterException
     */
    public function setUp() {
        $validatorFactory = new ValidatorFactory();
        $kernel = KernelFactory::getKernel();
        $container = $kernel -> getDic();
        $repositoryFactory = new RepositoryFactory($container);
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");

        $this -> commentServices = new CommentServices( $validatorFactory -> create(),$commentsRepository );
    }

    public function testShouldAddCommentWithValidComment() {
        $comments = new Comments();
        $comments -> setContent($this -> getContentValid());
        $comments -> setState(0);
        $comments -> setDateCreate( new \DateTimeImmutable() );
        $comments -> setIdPost(new Post());
        $comments -> setIdUser(new User());

        $this -> assertInstanceOf("\App\Entity\Comments",$this -> commentServices -> addComment($comments));
    }

    public function testShouldAddCommentButTheCommentContentIsntValid() {
        $this -> expectException("\App\Exception\EntityParametersErrorException");


        $comments = new Comments();
        $comments -> setContent($this -> getContentNotValid());

        $this -> commentServices -> addComment($comments);
    }

    private function getContentValid() {
        return "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
    }

    private function getContentNotValid() {
        return "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, contact@webmezenc.com,http://google.com/";
    }
}
