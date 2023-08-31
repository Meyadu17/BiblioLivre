<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/auteur', name: 'app_admin_auteur')]
class AdminAuteurController extends AbstractController
{
    #[Route('/', name: '_liste')]
    public function lister(AuteurRepository $auteurRepository): Response
    {
        $auteurs = $auteurRepository->findAll();

        return $this->render('admin/auteur/auteur_admin.html.twig', [
            'auteurs' => $auteurs,
        ]);

    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request, 
                           EntityManagerInterface $entityManager,
                           AuteurRepository $auteurRepository, 
                           int $id = null):Response
    {
        if($id == null){
            //Si id null, c'est que l'on créer le bien
            $auteur = new Auteur();
        }else{
            //S'il existe, on est dans le cas de la modification
            $auteur = $auteurRepository->find($id);
        }

        $form = $this->createForm(AuteurType::class, $auteur);

        //Permet de récupérer les données postées
        $form->handleRequest($request);

        //si le formulaire est soumis et est valide
        if($form->isSubmitted() && $form->isValid()) { 
            //traitement des données
            $entityManager->persist($auteur); //sauvegarde le bien
            $entityManager->flush(); //enregistrer en base
            
            //message de sucés et redirection sur la liste des livres
            $this->addFlash(
                        'success',
                        'l\'auteur a bien été édité !'
                    );

            return $this->redirectToRoute('app_admin_auteur_liste');
        }

        return  $this->render('admin/auteur/editer_admin.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function suprimer(EntityManagerInterface $entityManager,
                             AuteurRepository $auteurRepository, 
                             int $id):Response
    {
        
        //S'il existe, on est dans le cas de la modification
        $auteur = $auteurRepository->find($id);

        //traitement des données
        $entityManager->remove($auteur); //sauvegarde le bien
        $entityManager->flush(); //enregistre en base

        $this->addFlash(
            'success',
            'l\'auteur a bien été suprimé.');

        return  $this->redirectToRoute('app_admin_auteur_liste');
    }
}
