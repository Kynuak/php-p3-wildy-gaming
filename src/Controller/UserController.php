<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{
    #[Route('/profil', name:'user_profil')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $user = $this->getUser();
        $form =  $this->createForm(ProfileUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
        }

        $lotsUser = $this->getUser()->getLots();

        return $this->render('/mon_profil.html.twig', [
            "form" => $form,
            "lotsUser" => $lotsUser
        ]);
    }

    #[Route('/user/{idUser}', name:'user_delete', methods:['POST'])]
    public function delete(
        #[MapEntity(mapping: ['idUser' => "id"])] User $user,
        Request $request,
        EntityManagerInterface $entityManager,
        TokenStorageInterface $token
    ): Response {
        if ($this->isCsrfTokenValid((string)($user->getId()), $request->request->get('_token'))) {
            $token->setToken(null);
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }
}
