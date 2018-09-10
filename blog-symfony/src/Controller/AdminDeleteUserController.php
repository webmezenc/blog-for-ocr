<?php

namespace App\Controller;

use App\Domain\Command\User\DeleteCommandUser;
use App\Domain\UseCases\Issue50UseCases;
use App\Infrastructure\Repository\RepositoryFactory;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminDeleteUserController extends AppController
{
    /**
     * @Route("/admin/user/delete/{id}", name="admin_delete_user")
     */
    public function index($id)
    {
        return $this -> processController( array($this,'deleteUser'), [$id] );

    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \App\Exception\InfrastructureAdapterException
     */
    public function deleteUser($id) {
        $userRepository = $this -> getRepsitory();

        $deleteCommandUser = new DeleteCommandUser($userRepository);

        $issue50UseCases = new Issue50UseCases($deleteCommandUser,$userRepository);
        $issue50UseCases->setId($id);
        return $this -> render("admin/delete-user.html.twig",
            $issue50UseCases -> process()
        );
    }

    /**
     * @return \App\Infrastructure\Repository\Entity\RepositoryAdapterInterface
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getRepsitory() {
        $repositoryFactory = new RepositoryFactory($this->container);
        return $repositoryFactory->create("User");
    }
}
