<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 09/09/2018
 * Time: 18:49
 */

namespace App\Domain\UseCases;


use App\Domain\Command\Comment\PublishCommandComment;
use App\Exception\ParameterUndefinedException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class Issue45UseCases implements UseCasesLogicInterface
{

    /**
     * @var PublishCommandComment
     */
    private $publishCommandComment;

    /**
     * @var int
     */
    private $id;

    /**
     * @var RepositoryAdapterInterface
     */
    private $commentsRepository;

    /**
     * Issue45UseCases constructor.
     * @param PublishCommandComment $publishCommandComment
     * @param RepositoryAdapterInterface $commentsRepository
     */

    public function __construct
    (
        PublishCommandComment $publishCommandComment,
        RepositoryAdapterInterface $commentsRepository
    )
    {
        $this -> publishCommandComment = $publishCommandComment;
        $this -> commentsRepository = $commentsRepository;
    }


    public function setId(int $id) {
        $this -> id = $id;
    }


    /**
     * @return array
     *
     * @throws ParameterUndefinedException
     * @throws \App\Exception\EntityNotFoundException
     * @throws \App\Exception\ParameterIsNotFoundException
     */
    public function process(): array
    {
        if(!isset($this->id)) {
            throw new ParameterUndefinedException("Id must be defined");
        }

        $this -> publishCommandComment -> publish($this->id);
        $this -> commentsRepository -> getEntityManager() -> flush();

        return [
            "msg" => "commentSuccessfullPublish"
        ];
    }
}