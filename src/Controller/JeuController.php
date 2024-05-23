<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Entity\Equipe;
use App\Entity\CompositionEquipe;
use App\Repository\JeuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/jeu')]
class JeuController extends AbstractController
{
    #[Route('/', name: 'app_jeu_index', methods: ['GET'])]
    public function index(JeuRepository $jeuRepository): Response
    {
        return $this->render('jeu/index.html.twig', [
            'jeus' => $jeuRepository->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'app_jeu_show', methods: ['GET'])]
    public function show(JeuRepository $jeuRepository, Security $security,EntityManagerInterface $entityManager): Response
    {

        $jeu = new Jeu();
        $jeu->setDate(new \DateTime());
        $hote = $security->getUser();
        $eq1 = new Equipe();
        $compEq1 = new CompositionEquipe();
        $compEq1->isHote();
        $compEq1->setEquipe($eq1);
        $compEq1->setJoueur($hote);
        $entityManager->persist($jeu);
        $entityManager->flush();

        return $this->render('jeu/new.html.twig',
                            ['jeu' => $jeu
        ]);
    }

    #[Route('/{id}/edit', name: 'app_jeu_edit', methods: ['GET'])]
    public function edit(Jeu $jeu, EntityManagerInterface $entityManager): Response
    {
        // $form = $this->createForm(JeuType::class, $jeu);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager->flush();

        //     return $this->redirectToRoute('app_jeu_index', [], Response::HTTP_SEE_OTHER);
        // }

        return $this->render('jeu/edit.html.twig', [
            'jeu' => $jeu,
        ]);
    }

    #[Route('/{id}', name: 'app_jeu_delete', methods: ['POST'])]
    public function delete(Request $request, Jeu $jeu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jeu->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($jeu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_jeu_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/ajout_equipe')]
    public function ajoutEquipePartide(Request $request,EntityManagerInterface $entityManager){
        return new JsonResponse();
    }
}
