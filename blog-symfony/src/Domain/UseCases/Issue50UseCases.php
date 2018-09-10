<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 10/09/2018
 * Time: 18:05
 */

namespace App\Domain\UseCases;


use App\Domain\Command\User\DeleteCommandUser;
use App\Exception\EntityNotFoundException;
use App\Exception\ParameterUndefinedException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class Issue50UseCases implements UseCasesLogicInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DeleteCommandUser
     */
    private $deleteCommandUser;

    /**
     * @var RepositoryAdapterInterface
     */
    private $userRepository;


    /**
     * Issue50UseCases constructor.
     *
     * @param DeleteCommandUser $deleteCommandUser
     * @param RepositoryAdapterInterface $userRepository
     */
    public function __construct
    (
        DeleteCommandUser $deleteCommandUser,
        RepositoryAdapterInterface $userRepository
    )
    {
        $this->deleteCommandUser = $deleteCommandUser;
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) {
        $this->id = $id;
    }

    /**
     * @return array
     *
     * @throws EntityNotFoundException
     * @throws ParameterUndefinedException
     */
    public function process(): array
    {
        if(!isset($this->id)) {
            throw new ParameterUndefinedException("User id must be defined");
        }

        $this->deleteCommandUser->deleteUser($this->id);

        $this->userRepository->getEntityManager()->flush();

        return [
            "msg" => "userSuccessfullDeleted"
        ];
    }
}