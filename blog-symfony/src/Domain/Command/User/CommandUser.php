<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 10/09/2018
 * Time: 18:20
 */

namespace App\Domain\Command\User;


use App\Entity\User;
use App\Exception\EntityNotFoundException;
use App\Exception\ParameterUndefinedException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class CommandUser
{
    /**
     * @var RepositoryAdapterInterface
     */
    protected $userRepository;

    /**
     * @var int
     */
    private $id;

    /**
     * CommandUser constructor.
     * @param RepositoryAdapterInterface $userRepository
     */
    public function __construct( RepositoryAdapterInterface $userRepository )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) {
        $this->id = $id;
    }


    /**
     * @return User
     * @throws EntityNotFoundException
     * @throws ParameterUndefinedException
     */
    public function getUser():User {

        $this->isUserIdDefined();

        $user = $this->userRepository->find($this->id);

        $this->isEntityFound($user);

        return $user;
    }

    /**
     * @throws ParameterUndefinedException
     */
    private function isUserIdDefined(): void
    {
        if (!isset($this->id)) {
            throw new ParameterUndefinedException("User id must be defined");
        }
    }

    /**
     * @param $user
     * @throws EntityNotFoundException
     */
    private function isEntityFound($user): void
    {
        if (is_null($user)) {
            throw new EntityNotFoundException("User isn't found");
        }
    }

    /**
     * @param int $id
     *
     * @return User
     *
     * @throws EntityNotFoundException
     * @throws ParameterUndefinedException
     */
    public function defineUserAndGetUser(int $id) {
        $this->setId($id);
        return $this->getUser();
    }
}