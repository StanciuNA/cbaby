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
use App\Repository\JeuRepository;


class CbabyController extends AbstractController
{
    #[Route(path: '', name: 'accueil')]
    public function index(JeuRepository $jeuRepository): Response
    {

        $nb_match = count($jeuRepository->findAll())+1;
        return $this->render('base.html.twig', [
            'nb_match' => $nb_match,
        ]);
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

            $utilisateur->setPassword($mdpHashe);
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