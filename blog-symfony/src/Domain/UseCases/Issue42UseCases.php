<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/09/2018
 * Time: 20:10
 */

namespace App\Domain\UseCases;

use App\Entity\Comments;
use App\Exception\ParameterInvalidException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class Issue42UseCases implements UseCasesLogicInterface
{

    /**
     * @var RepositoryAdapterInterface
     */
    private $commentsRepository;

    /**
     * @var int
     */
    private $state;


    /**
     * Issue42UseCases constructor.
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
     * @param int $state
     */
    public function setState( int $state ) {
        $this -> state = $state;
    }

    /**
     * @return array
     * @throws ParameterInvalidException
     */
    public function process(): array
    {
        $statesList = [Comments::COMMENTS_INVALID,Comments::COMMENTS_VALID];

        $this->isValidCommentState($statesList);

        return [
           "commentsList" => $this -> getCommentsListWithState()
       ];
    }

    /**
     * @return array
     */
    private function getCommentsListWithState() {

        switch(isset($this->state)) {
            case true:
                return $this -> commentsRepository -> findBy(["state" => $this -> state]);
                break;
            case false:
                return $this -> commentsRepository -> findAll();
                break;
        }
    }

    /**
     * @param $statesList
     * @throws ParameterInvalidException
     */
    private function isValidCommentState($statesList): void
    {
        if (!in_array($this->state, $statesList)) {
            throw new ParameterInvalidException("The state must be in this list " . implode(",", $statesList));
        }
    }
}