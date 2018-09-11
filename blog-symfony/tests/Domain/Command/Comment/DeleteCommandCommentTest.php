<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 09/09/2018
 * Time: 18:14
 */

namespace App\Tests\Domain\Command\Comment;

use App\Domain\Command\Comment\DeleteCommandComment;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class DeleteCommandCommentTest extends TestCase
{
    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }

    public function testShouldObtainValidationWhenDeleteComment() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory->create("Comments","inMemory");

        $deleteCommandComment = new DeleteCommandComment($commentsRepository);
        $this->assertTrue($deleteCommandComment->delete(1));
    }
}
