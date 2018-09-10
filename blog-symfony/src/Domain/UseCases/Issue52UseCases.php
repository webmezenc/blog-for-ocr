<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 10/09/2018
 * Time: 21:14
 */

namespace App\Domain\UseCases;


use App\Entity\Post;
use App\Exception\ParameterUndefinedException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class Issue52UseCases implements UseCasesLogicInterface
{
    /**
     * @var RepositoryAdapterInterface
     */
    private $commentsRepository;


    /**
     * @var Post
     */
    private $post;


    /**
     * Issue52UseCases constructor.
     * @param RepositoryAdapterInterface $commentsRepository
     */

    public function __construct
    (
        RepositoryAdapterInterface $commentsRepository
    )
    {
        $this -> commentsRepository = $commentsRepository;
    }

    /**
     * @param Post $post
     */
    public function setPost( Post $post ) {
        $this->post = $post;
    }

    /**
     * @return array
     *
     * @throws ParameterUndefinedException
     */
    public function process(): array
    {
        $this->isDefinedPostParameter();

        return [
            "commentsList" => $this -> commentsRepository -> findCommentsPublishByPost($this -> post)
        ];
    }

    private function isDefinedPostParameter(): void
    {
        if (!isset($this->post)) {
            throw new ParameterUndefinedException("Post parameter isn't defined");
        }
    }
}