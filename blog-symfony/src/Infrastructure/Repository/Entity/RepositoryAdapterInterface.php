<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 19/08/2018
 * Time: 19:13
 */

namespace App\Infrastructure\Repository\Entity;

interface RepositoryAdapterInterface
{
    public function findAll();
    public function findOneBy(array $criteria, array $orderBy = null);
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
    public function find($id, $lockMode = null, $lockVersion = null);
}