<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 09/09/2018
 * Time: 18:24
 */

namespace App\Tests\Domain\Command\Comment;

use App\Domain\Command\Comment\PublishCommandComment;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Tests\Infrastructure\Kernel\KernelFactory;
use PHPUnit\Framework\TestCase;

class PublishCommandCommentTest extends TestCase
{
    private $container;

    public function setUp()
    {
        $kernel = KernelFactory::getKernel();
        $this->container = $kernel->getDic();
    }


    public function testShouldObtainValidationWhenPublishComment() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory->create("Comments","inMemory");

        $publishComment = new PublishCommandComment($commentsRepository);
        $this->assertTrue($publishComment->publish(1));
    }
}
