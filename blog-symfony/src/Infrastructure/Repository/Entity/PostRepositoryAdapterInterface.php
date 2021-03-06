<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 04/08/2018
 * Time: 12:56
 */

namespace App\Infrastructure\Repository\Entity;

use App\Entity\ValueObject\OrderLimit;

interface PostRepositoryAdapterInterface
{
    public function getValidPostWithOrderAndLimit( OrderLimit $orderLimit ): array;
    public function getNumberOfValidPost(): int;

}