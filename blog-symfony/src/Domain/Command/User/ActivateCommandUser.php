<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 10/09/2018
 * Time: 19:07
 */

namespace App\Domain\Command\User;


use App\Entity\User;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class ActivateCommandUser extends CommandUser
{
    /**
     * ActivateCommandUser constructor.
     * @param RepositoryAdapterInterface $userRepository
     */
    public function __construct(RepositoryAdapterInterface $userRepository)
    {
        parent::__construct($userRepository);
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws \App\Exception\EntityNotFoundException
     * @throws \App\Exception\ParameterUndefinedException
     */
    public function activateUser(int $id) {
        $user = $this -> defineUserAndGetUser($id);

        $user->setState(User::USER_ACTIVE);

        $this->userRepository->getEntityManager()->persist($user);

        return true;
    }
}