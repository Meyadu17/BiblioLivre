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
class AdminAuteurController extends AbstractController {

    #[Route('/', name: '_liste')]
    public function lister(Request $request,
                           EntityManagerInterface $entityManager,
                           AuteurRepository $auteurRepository,
                           int $id = null):Response {

    $auteur = new Auteur();

    $form = $this->createForm(AuteurType::class, $auteur);
    $form->handleRequest($request);

    if($form->isSubmitted() /*&& $form->isValid()*/) {
        $entityManager->persist($auteur);
        $entityManager->flush();
    }

    $auteurs = $auteurRepository->findAll();

    return $this->render('admin/auteur/auteur_admin.html.twig', [
        'auteurs' => $auteurs,
        'form' => $form,
    ]);

    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request, 
                           EntityManagerInterface $entityManager,
                           AuteurRepository $auteurRepository, 
                           int $id = null):Response {
        if($id == null){
            $auteur = new Auteur();
        }else{
            $auteur = $auteurRepository->find($id);
        }

        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if($form->isSubmitted() /*&& $form->isValid()*/) {
            $entityManager->persist($auteur);
            $entityManager->flush();
            
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
                             int $id):Response {
        
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
