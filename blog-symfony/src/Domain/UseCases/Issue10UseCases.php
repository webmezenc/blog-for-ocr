<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 28/08/2018
 * Time: 16:54
 */

namespace App\Domain\UseCases;


use App\Utils\Services\Post\PostServices;

class Issue10UseCases implements UseCasesLogicInterface
{
    /**
     * @var PostServices
     */
    private $postServices;

    public function __construct( PostServices $postServices )
    {
        $this -> postServices = $postServices;
    }

    public function process(): array
    {
        return [
            "posts" =>  $this -> postServices -> getListPost(0,5)
            ];
    }
}