<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 31/08/2018
 * Time: 19:01
 */

namespace App\Domain\Command\Post;

use App\Entity\Post;
use App\Exception\EntityParametersErrorException;
use App\Infrastructure\InfrastructureValidatorInterface;

class AddPostWithActualUser
{
    /**
     * @var InfrastructureValidatorInterface
     */
    private $validator;

    public function __construct( InfrastructureValidatorInterface $validator )
    {
        $this -> validator = $validator;
    }

    /**
     * @param Post $post
     *
     * @return Post
     */
    public function addPost( Post $post ): Post {

        if( !$this -> validator -> validate($post) ) {
            throw new EntityParametersErrorException("Your Post entity parameters isn't a valid : ".implode(", ",$this -> validator -> getErrors()) );
        }


    }
}