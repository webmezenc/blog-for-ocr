<?php

namespace App\Controller;

use App\Domain\Command\User\ActivateCommandUser;
use App\Domain\UseCases\Issue41UseCases;
use App\Infrastructure\Repository\RepositoryFactory;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminActivateUserController extends AppController
{
    /**
     * @Route("/admin/user/activate/{id}", name="admin_activate_user")
     */
    public function index($id)
    {
        return $this -> processController( array($this,'activateUser'), [$id] );
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \App\Exception\InfrastructureAdapterException
     */
    public function activateUser($id) {
        $userRepository = $this -> getRepository();

        $activateCommandUser = new ActivateCommandUser($userRepository);

        $issue41UseCases = new Issue41UseCases($activateCommandUser,$userRepository);
        $issue41UseCases->setId($id);
        return $this -> render("admin/activate-user.html.twig",
            $issue41UseCases -> process()
        );
    }

    /**
     * @return \App\Infrastructure\Repository\Entity\RepositoryAdapterInterface
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getRepository() {
        $repositoryFactory = new RepositoryFactory($this->container);
        return $repositoryFactory->create("User");
    }
}
