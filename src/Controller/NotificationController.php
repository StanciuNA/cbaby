<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Joueur;
use App\Entity\Notification;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use App\Repository\JoueurRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    
}


?>