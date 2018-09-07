<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 06/09/2018
 * Time: 15:35
 */

namespace App\Infrastructure\Repository;


use App\Exception\AlreadyExistException;
use App\Exception\NotFoundException;
use App\Infrastructure\InfrastructureRepositoryCollectionInterface;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class RepositoryCollection implements InfrastructureRepositoryCollectionInterface
{
    /**
     * @var array
     */
    private $repositoryCollection = [];


    /**
     * @param string $name
     * @param RepositoryAdapterInterface $repository
     *
     * @throws AlreadyExistException
     */
    public function add(string $name, RepositoryAdapterInterface $repository)
    {
        if(key_exists($name,$this -> repositoryCollection)) {
            throw new AlreadyExistException("This repository ".$name." already exist in collection");
        }

        $this -> repositoryCollection[ $name ] = $repository;
    }


    /**
     * @param string $name
     *
     * @return RepositoryAdapterInterface
     *
     * @throws NotFoundException
     */
    public function get(string $name): RepositoryAdapterInterface
    {
        $this->isExist($name);

        return $this -> repositoryCollection[$name];

    }


    public function all(): array
    {
        return $this -> repositoryCollection;
    }

    public function remove(string $name)
    {
        $this->isExist($name);

        unset($this -> repositoryCollection[$name]);

    }

    /**
     * @param string $name
     * @throws NotFoundException
     */
    private function isExist(string $name): void
    {
        if (!key_exists($name, $this->repositoryCollection)) {
            throw new NotFoundException("Repository named " . $name . " isn't found in this collection");
        }
    }
}