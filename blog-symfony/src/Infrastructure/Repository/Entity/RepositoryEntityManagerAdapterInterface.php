<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 19/08/2018
 * Time: 19:13
 */

namespace App\Infrastructure\Repository\Entity;

interface RepositoryEntityManagerAdapterInterface
{
    public function getEntityManager();
}