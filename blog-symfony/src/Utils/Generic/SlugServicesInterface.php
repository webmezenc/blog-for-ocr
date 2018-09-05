<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/09/2018
 * Time: 11:40
 */

namespace App\Utils\Generic;


interface SlugServicesInterface
{
    static public function slugify( string $chain ): string;
}