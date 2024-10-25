<?php

namespace App\Controller;
use App\Repository\AnnoncesRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Agence;
use App\Entity\Annonces;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

use App\Form\AnnoncesType; 

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CrudAnnonceController extends AbstractController
{
    #[Route('/crud/annonce', name: 'app_crud_annonce')]
    public function index(): Response
    {
        return $this->render('crud_annonce/index.html.twig', [
            'controller_name' => 'CrudAnnonceController',
        ]);
    }
}
