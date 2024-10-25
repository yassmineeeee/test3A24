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
#[Route('/crud/annonces')]
class CrudAnnoncesController extends AbstractController
{
    #[Route('/list', name: 'app_list_Annonces')]

    public function listAnnonces(AnnoncesRepository $repository): Response
    {
        
        $Annonces=$repository->findAll();
        return $this->render('crud_Annonces/ListAnnonces.html.twig',['Annonces'=>$Annonces]);
    }
    
    #[Route("/delete/{id}", name: 'app_delete_Annonces')]
    public function deleteAnnonces($id, AnnoncesRepository $repository, ManagerRegistry $doctrine): Response
{
    
    $Annonces = $repository->find($id);

    
    if (!$Annonces) {
        throw $this->createNotFoundException('Annonces not found');
    }

    $em = $doctrine->getManager();
    $em->remove($Annonces);
    $em->flush();

    
    $this->addFlash('success', 'Annonces deleted successfully.');

    return $this->redirectToRoute('app_list_Annonces');
}

        #[Route('/edit/{id}', name: 'app_Annonces_edit')]
        public function edit(
            int $id,
            Request $request,
            EntityManagerInterface $entityManager
        ): Response {
            $Annonces = $entityManager->getRepository(Annonces::class)->find($id);
        
            if (!$Annonces) {
                throw $this->createNotFoundException('Annonces not found');
            }
        
            $form = $this->createForm(AnnoncesType::class, $Annonces);
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();
        
                $this->addFlash('success', 'Annonces updated successfully.');
        
                return $this->redirectToRoute('app_list_Annonces');
            }
        
            return $this->render('crud_Annonces/form_Edit_Annonces.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        #[Route('/insert', name: 'app_insertform_Annonces')]
        public function insertFormAnnonces(Request $request, ManagerRegistry $doctrine): Response
        {
            $Annonces = new Annonces();
            $form = $this->createForm(AnnoncesType::class, $Annonces);  
    
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $doctrine->getManager(); //entity maager
                $em->persist($Annonces);
                $em->flush();

                // Flash message for successful addition
            $this->addFlash('success', 'Annonces added successfully.');
    
                return $this->redirectToRoute('app_list_Annonces');
            }
    
            return $this->render('crud_annonces/formAnnonces.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    
}
