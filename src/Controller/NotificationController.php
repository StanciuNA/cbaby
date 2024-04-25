<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Entity\Equipe;
use App\Form\JoueurType;
use App\Repository\JoueurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class NotificationController extends AbstractController{

    public function notifAjoutEquipe(Request $request,Equipe $equipe, Joueur $joueur){
        
    }

}


?>