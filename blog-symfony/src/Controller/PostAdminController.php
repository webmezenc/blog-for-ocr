<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/09/2018
 * Time: 16:57
 */

namespace App\Controller;


use App\Infrastructure\Repository\RepositoryFactory;

class PostAdminController extends AppController
{
    /**
     * @var array
     */
    protected $repositories;


    /**
     * @return array
     * @throws \App\Exception\InfrastructureAdapterException
     */
    protected function getRepositories()
    {
        if(isset($this -> repositories)) {
            return $this -> repositories;
        }

        $repositoryFactory = new RepositoryFactory($this->container);
        $postRepository = $repositoryFactory->create("Post");
        $postCategoryRepository = $repositoryFactory->create("PostCategory");

        $this -> repositories = [
            "Post" => $postRepository,
            "PostCategory" => $postCategoryRepository
        ];

    }



}