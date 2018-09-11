<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/09/2018
 * Time: 12:54
 */

namespace App\Domain\UseCases;


use App\Exception\ParameterIsNotFoundException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Utils\Generic\ParametersBagInterface;

class Issue34UseCases implements UseCasesLogicInterface
{
    /**
     * @var RepositoryAdapterInterface
     */
    private $postRepository;

    /**
     * @var ParametersBagInterface
     */
    private $parametersBag;

    public function __construct(
        RepositoryAdapterInterface $postRepository,
        ParametersBagInterface $parametersBag
    )
    {
        $this -> postRepository = $postRepository;
        $this -> parametersBag = $parametersBag;
    }


    public function process(): array
    {
        if(!$this -> parametersBag -> has("state")) {
            return $this->getAllPosts();
        } else {
            return $this->getPostWithState();
        }

    }

    /**
     * @return mixed
     */
    private function getPostWithState()
    {
        return $this->postRepository->findBy(
            ["state" => $this->parametersBag->get("state")]
        );
    }

    /**
     * @return mixed
     */
    private function getAllPosts()
    {
        return $this->postRepository->findAll();
    }

}