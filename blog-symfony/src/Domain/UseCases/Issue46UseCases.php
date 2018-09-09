<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 09/09/2018
 * Time: 14:42
 */

namespace App\Domain\UseCases;


use App\Entity\Comments;
use App\Exception\EntityNotFoundException;
use App\Exception\ParameterIsNotFoundException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class Issue46UseCases implements UseCasesLogicInterface
{
    /**
     * @var RepositoryAdapterInterface
     */
    private $commentsRepository;

    /**
     * @var int
     */
    private $idComment;

    /**
     * Issue46UseCases constructor.
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
     * @param int $idComment
     */
    public function setIdComment(int $idComment) {
        $this -> idComment = $idComment;
    }

    /**
     * @return array
     *
     * @throws EntityNotFoundException
     * @throws ParameterIsNotFoundException
     */
    public function process(): array
    {
        $this->isDefinedIdComment();

        $comment = $this -> commentsRepository -> find($this->idComment);

        if(is_null($comment)) {
            throw new EntityNotFoundException("Comment identified by ".$this->idComment." isn't found");
        }

        $this->removeComment($comment);

        return [
            "msg" => "commentSuccessfullDeleted"
        ];
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

    /**
     * @param Comments $comment
     */
    private function removeComment(Comments $comment): void
    {
        $this->commentsRepository->getEntityManager()->remove($comment);
        $this->commentsRepository->getEntityManager()->flush();
    }
}