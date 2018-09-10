<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 09/09/2018
 * Time: 17:43
 */

namespace App\Tests\Domain\Command\Comment;

use App\Domain\Command\Comment\CommandComment;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class CommandCommentTest extends TestCase
{

    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }

    public function testShouldObtainACommentWhenCommentExist() {

        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");

        $commandComment = new CommandComment($commentsRepository);
        $commandComment->setIdComment(1);
        $this -> assertInstanceOf("\App\Entity\Comments",$commandComment -> getComment());
    }

    public function testShouldDeleteACommentButCommentIsntExist() {
        $this -> expectException("\App\Exception\EntityNotFoundException");

        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");


        $commandComment = new CommandComment($commentsRepository);
        $commandComment->setIdComment(99999);
        $commandComment -> getComment();
    }

    public function testShouldObtainAnErrorWhenIdCommentsIsntFound() {
        $this -> expectException("\App\Exception\ParameterIsNotFoundException");

        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory -> create("Comments","inMemory");

        $commandComment = new CommandComment($commentsRepository);
        $commandComment -> getComment();
    }

}
