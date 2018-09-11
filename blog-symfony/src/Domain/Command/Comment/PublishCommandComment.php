<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 09/09/2018
 * Time: 18:22
 */

namespace App\Domain\Command\Comment;


use App\Entity\Comments;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class PublishCommandComment extends CommandComment
{

    /**
     * PublishCommandComment constructor.
     * @param RepositoryAdapterInterface $commentsRepository
     */
    public function __construct(RepositoryAdapterInterface $commentsRepository)
    {
        parent::__construct($commentsRepository);
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws \App\Exception\EntityNotFoundException
     * @throws \App\Exception\ParameterIsNotFoundException
     */
    public function publish(int $id): bool {
        $comment = $this -> defineCommentAndGetComment($id);

        $comment -> setState( Comments::COMMENTS_VALID );
        $comment -> setDateValidation( new \DateTime() );

        $this -> commentsRepository -> persist($comment);

        return true;
    }


}