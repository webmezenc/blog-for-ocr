<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 08/09/2018
 * Time: 14:22
 */

namespace App\Domain\UseCases;


use App\Entity\User;
use App\Exception\ParameterInvalidException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class Issue19UseCases implements UseCasesLogicInterface
{
    /**
     * @var RepositoryAdapterInterface
     */
    private $userRepository;

    /**
     * @var int
     */
    private $stateUser;



    public function __construct
    (
        RepositoryAdapterInterface $userRepository
    )
    {
        $this -> userRepository = $userRepository;
    }


    /**
     * @param int $stateUser
     *
     * @throws ParameterInvalidException
     */
    public function setStateUser(int $stateUser) {

        $userStateList = [User::USER_ACTIVE,User::USER_INACTIVE];

        $this->isValidStateUser($stateUser, $userStateList);

        $this -> stateUser = $stateUser;
    }


    /**
     * @return array
     */
    public function process(): array
    {
        return ["userList" => $this -> findUserWithStateUser()];
    }

    /**
     * @return array
     */
    private function findUserWithStateUser(): array {

        switch(isset($this -> stateUser)) {
            case true:
                return $this -> userRepository -> findBy(["state" => $this -> stateUser]);
                break;
            case false:
                return $this -> userRepository -> findAll();
                break;
        }

    }

    /**
     * @param int $stateUser
     * @param $userStateList
     * @throws ParameterInvalidException
     */
    private function isValidStateUser(int $stateUser, $userStateList): void
    {
        if (!in_array($stateUser, $userStateList)) {
            throw new ParameterInvalidException("State user must be in this list " . implode(",", $userStateList));
        }
    }
}