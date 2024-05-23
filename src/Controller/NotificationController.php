<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Joueur;
use App\Entity\Jeu;
use App\Entity\Notification;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use App\Repository\JoueurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;


class NotificationController extends AbstractController {

    #[Route('/inviter')]
    public function getInvitation(Request $request,Security $security,EntityManagerInterface $entityManager){
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $expediteur = $security->getUser();
        $notification = new Notification();
        $utilisateur_id = $data['utilisateur_id'];
        $type = $data['type'];
        $destinataire = $entityManager->getRepository(Joueur::class)->find($utilisateur_id);
        $notification->setExpediteur($expediteur);
        $notification->setDestinataire($destinataire);
        $notification->setType($type);
        $entityManager->persist($notification);

        $entityManager->flush();

        return new JsonResponse(["data"=>"test"]);
    }

    #[Route('/inviter/jeu',methods: ['GET', 'POST'])]
    public function invitJeu(Request $request,Security $security,EntityManagerInterface $entityManager){
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $expediteur = $security->getUser();
        $id_joueur = $data["joueur"]["id"];
        $destinataire = $entityManager->getRepository(Joueur::class)->find($id_joueur);
        $notification = new Notification();
        $notification->setExpediteur($expediteur);
        $notification->setType("inv_jeu");
        $notification->setDestinataire($destinataire);
        $notification->setData($data);
        $entityManager->persist($notification);
        $entityManager->flush();

        return new JsonResponse(["data"=>$data["joueur"]]);
    }

    #[Route('/notifications',methods: ['GET', 'POST'])]
    public function Notifications(Request $request,Security $security,EntityManagerInterface $entityManager){
        $utilisateur = $security->getUser();
    }
}


?>