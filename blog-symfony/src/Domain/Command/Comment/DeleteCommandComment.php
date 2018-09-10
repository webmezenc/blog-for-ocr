<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 09/09/2018
 * Time: 18:13
 */

namespace App\Domain\Command\Comment;


use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class DeleteCommandComment extends CommandComment
{
    /**
     * DeleteCommandComment constructor.
     * @param RepositoryAdapterInterface $commentsRepository
     */
    public function __construct(RepositoryAdapterInterface $commentsRepository)
    {
        parent::__construct($commentsRepository);
    }

    /**
     * @param int $id
     *
     * @throws \App\Exception\EntityNotFoundException
     * @throws \App\Exception\ParameterIsNotFoundException
     */
    public function delete(int $id) {

        $comment = $this -> defineCommentAndGetComment($id);

        $this -> commentsRepository -> getEntityManager() -> remove($comment);

        return true;
    }
}