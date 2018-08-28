<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 24/08/2018
 * Time: 19:17
 */

namespace App\Utils\Services\Comment;

use App\Entity\Comments;
use App\Exception\EntityParametersErrorException;
use App\Infrastructure\InfrastructureValidatorInterface;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class CommentServices
{

    /**
     * @var InfrastructureValidatorInterface
     */
    private $validator;

    /**
     * @var RepositoryAdapterInterface
     */
    private $repository;


    public function __construct( InfrastructureValidatorInterface $validator, RepositoryAdapterInterface $repositoryAdapter )
    {
        $this -> validator = $validator;
        $this -> repository = $repositoryAdapter;
    }


    /**
     * @param Comments $comments
     *
     * @return Comments
     *
     * @throws EntityParametersErrorException
     */
    public function addComment( Comments $comments ) {

        if( !$this -> validator -> validate($comments) ) {
            throw new EntityParametersErrorException("Errors has occurred when validate comment : ".implode(",", $this -> validator -> getErrors()));
        }

        $this -> repository -> persist($comments);

        return $comments;
    }
}