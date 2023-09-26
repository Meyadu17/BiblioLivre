<?php

namespace App\Controller;

use App\Entity\Bibliotheque;
use App\Form\BibliothequeType;
use App\Repository\BibliothequeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bibliotheque', name: 'app_bibliotheque')]
class BibliothequeController extends AbstractController
{
    #[Route('/liste', name: '_liste')]
    public function index(BibliothequeRepository $bibliothequeRepository): Response
    {
        $bibliotheques = $bibliothequeRepository->findAll();

        return $this->render('bibliotheque/index.html.twig', [
            'bibliotheques' => $bibliotheques,
        ]);
    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request                $request,
                           EntityManagerInterface $entityManager,
                           BibliothequeRepository $bibliothequeRepository,
                           int                    $id = null): Response
    {

        if ($id == null) {
            //Si id null, c'est que l'on créer la bibliothèque
            $bibliotheque = new Bibliotheque();
            //$livreBibliotheque = new LivreBibliotheque();
            //$bibliotheque->addLivreBibliotheque($livreBibliotheque);
            $bibliotheque->setUser($this->getUser());
            $bibliotheque->setModifiable(true);
        } else {
            //S'il existe, on est dans le cas de la modification
            $bibliotheque = $bibliothequeRepository->find($id);

            //je contrôle que la bibliothèque appartient au bon user
            if ($bibliotheque->getUser() !== $this->getUser()) {
                $this->addFlash(
                    'danger',
                    'Non petit coquin, je sais où tu habites !'
                );

                return $this->redirectToRoute('app_bibliotheque_liste');
            }
        }

        $form = $this->createForm(BibliothequeType::class, $bibliotheque);

        //Permet de récupérer les données postées
        $form->handleRequest($request);

        //si le formulaire est soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {

            //traitement des données
            $entityManager->persist($bibliotheque); //sauvegarde le bien
            $entityManager->flush(); //enregistrer en base

            //message de succés et redirection sur la liste des livres
            $this->addFlash(
                'success',
                'la bibliothèque à bien été ' . ($id == null ? 'ajouté' : 'modifié') . ' !'
            );

            return $this->redirectToRoute('app_bibliotheque_liste');
        }

        return $this->render('bibliotheque/editer_bibliotheque.html.twig', [
            'form' => $form,
            //'bibliotheque' => $bibliotheque,
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function suprimer(EntityManagerInterface $entityManager,
                             BibliothequeRepository $bibliothequeRepository,
                             int                    $id): Response
    {

        $bibliotheque = $bibliothequeRepository->find($id);
        $entityManager->remove($bibliotheque);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'la bibliothèque a bien été suprimée.'
        );

        return $this->redirectToRoute('app_bibliotheque_liste');
    }

}
