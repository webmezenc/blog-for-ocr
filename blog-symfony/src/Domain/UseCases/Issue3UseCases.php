<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 04/08/2018
 * Time: 12:07
 */

namespace App\Domain\UseCases;


use App\Utils\Services\Post\PostServices;

class Issue3UseCases implements UseCasesLogicInterface
{

    /**
     * @var PostServices
     */
    private $postServices;

    /**
     * Issue3UseCases constructor.
     */
    public function __construct( PostServices $postServices )
    {
        $this -> postServices = $postServices;
    }

    /**
     * @return array
     */
    public function process(): array
    {
        //$post = $this -> postServices -> find
    }


}