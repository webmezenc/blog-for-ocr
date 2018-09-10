<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 10/09/2018
 * Time: 18:29
 */

namespace App\Domain\Command\User;


use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class DeleteCommandUser extends CommandUser
{
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
    public function deleteUser(int $id) {
        $user = $this -> defineUserAndGetUser($id);
        $this->userRepository->getEntityManager()->remove($user);

        return true;
    }
}