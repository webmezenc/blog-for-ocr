<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 10/09/2018
 * Time: 18:59
 */

namespace App\Domain\UseCases;


use App\Domain\Command\User\ActivateCommandUser;
use App\Exception\ParameterUndefinedException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class Issue41UseCases implements UseCasesLogicInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var ActivateCommandUser
     */
    private $activateCommandUser;

    /**
     * @var RepositoryAdapterInterface
     */
    private $userRepository;

    /**
     * Issue41UseCases constructor.
     * @param ActivateCommandUser $activateCommandUser
     * @param RepositoryAdapterInterface $userRepository
     */
    public function __construct
    (
        ActivateCommandUser $activateCommandUser,
        RepositoryAdapterInterface $userRepository
    )
    {
        $this->activateCommandUser = $activateCommandUser;
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) {
        $this -> id = $id;
    }

    /**
     * @return array
     * @throws ParameterUndefinedException
     * @throws \App\Exception\EntityNotFoundException
     */
    public function process(): array
    {
        if(!isset($this->id)) {
            throw new ParameterUndefinedException("User id must be defined");
        }

        $this->activateCommandUser->activateUser($this->id);

        $this->userRepository->getEntityManager()->flush();

        return [
            "msg" => "userSuccessfullActivate"
        ];
    }
}