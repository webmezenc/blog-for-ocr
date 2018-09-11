<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 16:05
 */

namespace App\Infrastructure;


interface InfrastructureValidatorInterface
{
    public function validate($entity): bool;
    public function getErrors(): array;
}