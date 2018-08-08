<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 08/08/2018
 * Time: 19:31
 */

namespace App\Utils\Generic;


interface ParametersBagInterface
{
    public function all(): array;
    public function add( array $parameters = array() );
    public function get( string $key );
    public function has( string $key ): bool;
}