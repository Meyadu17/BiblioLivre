<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/main', name: 'app_admin_main')]
class AdminMainController extends AbstractController
{
    #[Route('/', name: '_liste')]
    public function lister(LivreRepository $livreRepository): Response
    {
        $livres = $livreRepository->findAll();

        return $this->render('admin/main/main_admin.html.twig', [
            'livres' => $livres,
        ]);

    }

    //Attention à l'import du request : HttpFoundation
    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request, 
                           EntityManagerInterface $entityManager,
                           LivreRepository $livreRepository, 
                           int $id = null):Response
    {
        if($id == null){
            //Si id null, c'est que l'on créer le bien
            $livre = new Livre();
        }else{
            //S'il existe, on est dans le cas de la modification
            $livre = $livreRepository->find($id);
        }

        $form = $this->createForm(LivreType::class, $livre);

        //Permet de récupérer les données postées
        $form->handleRequest($request);

        //si le formulaire est soumis et est valide
        if($form->isSubmitted() && $form->isValid()) { 
            //traitement des données
            $entityManager->persist($livre); //sauvegarde le bien
            $entityManager->flush(); //enregistrer en base
            
            //message de sucés et redirection sur la liste des livres
            $this->addFlash(
                        'success',
                        'le livre à bien été édité !'
                    );

            return $this->redirectToRoute('app_admin_main_liste');
        }

        return  $this->render('admin/main/editer_admin.html.twig', [
            'form' => $form,
        ]);
    }
    
}
