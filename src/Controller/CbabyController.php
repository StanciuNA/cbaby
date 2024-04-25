<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Equipe;
use App\Entity\CompositionEquipe;
use App\Form\EnregistrerType;


class CbabyController extends AbstractController
{
    #[Route(path: '', name: 'accueil')]
    public function index(): Response
    {
        $contents = $this->render('index.html.twig');

        return new Response(
            $contents
        );
    }

    #[Route('/enregistrer', name: 'app_register')]
    public function enregistrer(Request $request,UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager,Security $security): Response
    {

        $form = $this->createForm(EnregistrerType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $form->getData();
            $mdpHashe = $passwordHasher->hashPassword(
                $utilisateur,
                $utilisateur->getPassword()
            );
            $equipe = new Equipe();
            $equipe->setNom($utilisateur->getPseudo());
            $composition_eq = new CompositionEquipe();
            $utilisateur->addComposition($composition_eq);
            $utilisateur->setPassword($mdpHashe);
            $composition_eq->setHote(true);
            $composition_eq->setEquipe($equipe);
            $entityManager->persist($equipe);
            $entityManager->persist($composition_eq);
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            $security->login($utilisateur);
            return $this->redirectToRoute('accueil');
        }

        return $this->render('enregistrer.html.twig', [
            'form' => $form,
        ]);

    }
}