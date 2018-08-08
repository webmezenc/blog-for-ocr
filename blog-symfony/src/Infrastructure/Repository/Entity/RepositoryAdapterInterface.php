<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/08/2018
 * Time: 10:32
 */

namespace App\Infrastructure\Repository\Entity;


interface RepositoryAdapterInterface
{
    public function findBy( array $params );
    public function findOneBy( array $params );
}