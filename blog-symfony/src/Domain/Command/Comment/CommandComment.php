<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 09/09/2018
 * Time: 17:29
 */

namespace App\Domain\Command\Comment;


use App\Entity\Comments;
use App\Exception\EntityNotFoundException;
use App\Exception\ParameterIsNotFoundException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class CommandComment
{
    /**
     * @var RepositoryAdapterInterface
     */
    protected $commentsRepository;


    /**
     * @var int
     */
    private $idComment;

    /**
     * CommandComment constructor.
     * @param RepositoryAdapterInterface $commentsRepository
     */
    public function __construct( RepositoryAdapterInterface $commentsRepository )
    {
        $this -> commentsRepository = $commentsRepository;
    }

    /**
     * @param int $idComment
     *
     * @return Comments
     *
     * @throws EntityNotFoundException
     * @throws ParameterIsNotFoundException
     */
    public function defineCommentAndGetComment(int $idComment): Comments {
        $this -> setIdComment($idComment);
        return $this -> getComment();
    }


    /**
     * @param int $idComment
     */
    public function setIdComment(int $idComment) {
        $this -> idComment = $idComment;
    }


    /**
     * @return Comments
     *
     * @throws EntityNotFoundException
     * @throws ParameterIsNotFoundException
     */
    public function getComment(): Comments {

        $this -> isDefinedIdComment();

        $comment = $this -> commentsRepository -> find($this->idComment);

        if(is_null($comment)) {
            throw new EntityNotFoundException("Comment identified by ".$this->idComment." isn't found");
        }

        return $comment;

    }


    /**
     * @throws ParameterIsNotFoundException
     */
    private function isDefinedIdComment(): void
    {
        if (empty($this->idComment)) {
            throw new ParameterIsNotFoundException("ID comment must be defined");
        }
    }
}