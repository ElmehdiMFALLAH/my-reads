<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OperatorRepository;
use App\Repository\UserOperatorRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'users_list')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/{id}', name: 'update_user')]
    public function update(User $user, OperatorRepository $operatorRepository, UserOperatorRepository $userOperatorRepository, Request $request): Response
    {
        $operators = $operatorRepository->findAll();
        $userAllowedOperators = $userOperatorRepository->findBy(['user_id' => $user->getId()]);
        $userAllowedOperatorsIds = [];

        foreach ($userAllowedOperators as $userAllowedOperator) {
            array_push($userAllowedOperatorsIds, $userAllowedOperator->getOperatorId());   
        }

        if ($request->isMethod('POST')) {
            $checkedOperators = $request->get("operator");
            foreach ($checkedOperators as $checkedOperator) {
                if (!in_array($checkedOperator, $userAllowedOperatorsIds)) {
                    // todo: add user_operator
                }
            }
        }

        return $this->render('user/update.html.twig', [
            'users' => $user,
            'operators' => $operators,
            'userAllowedOperatorsIds' => $userAllowedOperatorsIds
        ]);
    }
}
