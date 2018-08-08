<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/08/2018
 * Time: 13:49
 */

namespace App\Infrastructure;


interface InfrastructureRequestInterface
{
    public function getRequest();
    public function getQuery();
    public function getCookies();
    public function getFiles();
    public function getServer();
    public function getHeaders();
}