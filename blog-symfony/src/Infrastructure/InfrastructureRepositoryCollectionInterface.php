<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 06/09/2018
 * Time: 15:33
 */

namespace App\Infrastructure;

use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

interface InfrastructureRepositoryCollectionInterface
{
    public function add(string $name, RepositoryAdapterInterface $repository);
    public function get(string $name): RepositoryAdapterInterface;
    public function all(): array;
    public function remove(string $name);
}