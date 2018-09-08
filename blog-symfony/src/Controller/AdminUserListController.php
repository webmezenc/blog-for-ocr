<?php

namespace App\Controller;

use App\Domain\UseCases\Issue19UseCases;
use App\Entity\User;
use App\Infrastructure\Repository\RepositoryFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminUserListController extends AppController
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @Route("/admin/user", name="admin_user_list")
     */
    public function index( Request $request)
    {
        $this -> request = $request;
        return $this -> processController( array($this,'getUserList'), [] );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \App\Exception\InfrastructureAdapterException
     */
    public function getUserList() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        $userRepository = $repositoryFactory -> create("User");

        $issue19UseCases = new Issue19UseCases($userRepository);

        if($this -> request -> query -> has("state")) {
            $issue19UseCases -> setStateUser($this -> request -> query -> get("state"));
        }

        return $this -> render("admin/list-users.html.twig", array_merge(
            $issue19UseCases -> process(),$this -> getUserStates()
            ));

    }


    private function getUserStates() {
        return [
            "usersState" =>
                array(
                    "Inactif" => User::USER_INACTIVE,
                    "Actif" => User::USER_ACTIVE
                )
        ];
    }
}
