<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/09/2018
 * Time: 20:10
 */

namespace App\Domain\UseCases;

use App\Domain\Command\Post\DeletePostWithActualUser;
use App\Exception\ParameterIsNotFoundException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Repository\PostRepository;

class Issue36UseCases implements UseCasesLogicInterface
{

    const POST_DELETE_SUCCESS = "postDeleteSuccess";

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var DeletePostWithActualUser
     */
    private $deletePostWithActualUser;

    /**
     * Issue36UseCases constructor.
     *
     * @param PostRepository $postRepository
     */
    public function __construct
    (
        RepositoryAdapterInterface $postRepository,
        DeletePostWithActualUser $deletePostWithActualUser
    )
    {
        $this -> postRepository = $postRepository;
        $this -> deletePostWithActualUser = $deletePostWithActualUser;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug) {
        $this -> slug = $slug;
    }

    /**
     * @return array
     *
     * @throws ParameterIsNotFoundException
     */
    public function process(): array
    {
        if(is_null($this -> slug)) {
            throw new ParameterIsNotFoundException("The slug parameter must be defined");
        }

        $this -> deletePostWithActualUser -> deletePost($this -> slug);

        return [
            "msg" => self::POST_DELETE_SUCCESS
        ];
    }
}