<?php

namespace App\Controller;

use App\Entity\Bibliotheque;
use App\Form\BibliothequeType;
use App\Repository\BibliothequeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bibliotheque', name: 'app_bibliotheque')]
class BibliothequeController extends AbstractController
{
    #[Route('/liste', name: '_liste')]
    public function index(BibliothequeRepository $bibliothequeRepository,
                          Security $security,
                          Request $request,
                          EntityManagerInterface $entityManager,
                          int                    $id = null): Response
    {
        //#region modal
        if ($id == null) {
            //Si id null, c'est que l'on créer la bibliothèque
            $bibliotheque = new Bibliotheque();
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

            $bibliotheque->setUser($this->getUser());
            $bibliotheque->setModifiable(true);

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
        //#endregion modal

        //#region afficher les bibliothèques
        // Récupérer l'utilisateur actuel
        $user = $security->getUser();
        $bibliotheque->setUser($this->getUser());
        if (!$user) {
            // Gérer le cas où l'utilisateur n'est pas connecté
            return $this->redirectToRoute('app_login');
        }
        $bibliotheques = $bibliothequeRepository->findBy(['user' => $user]);
        //#endregion afficher les bibliothèques
        return $this->render('bibliotheque/index.html.twig', [
            'bibliotheques' => $bibliotheques,
            'form' => $form,
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
