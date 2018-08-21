<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 21/08/2018
 * Time: 15:52
 */

namespace App\Infrastructure;


interface InfrastructureRenderInterface
{
    public function renderView(string $view, $params = array()): string;
}