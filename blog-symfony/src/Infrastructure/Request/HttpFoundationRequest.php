<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/08/2018
 * Time: 13:42
 */

namespace App\Infrastructure\Request;


use App\Infrastructure\InfrastructureRequestInterface;
use Symfony\Component\HttpFoundation\Request;

class HttpFoundationRequest implements InfrastructureRequestInterface
{

    private $request;

    public function __construct( Request $request )
    {
        $this -> request = $request;
    }

    public function getRequest()
    {
        return $this -> request -> request;
    }

    public function getQuery()
    {
        return $this -> request -> query;
    }

    public function getCookies()
    {
        return $this -> request -> cookies;
    }

    public function getFiles()
    {
        return $this -> request -> files;
    }

    public function getServer()
    {
        return $this -> request -> server;
    }

    public function getHeaders()
    {
        return $this -> request -> headers;
    }


}