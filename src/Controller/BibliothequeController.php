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
        //recupération de l'id du user connecté
        $user = $this->getUser();
        //récupérer les bibliothèques associées à cet utilisateur
        if ($user) {
            $bibliotheques = $user->getBibliotheques();
        } else {
            return $this->redirectToRoute('app_login');
        }


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
            //Si id null, c'est que l'on créer le bien
            $bibliotheque = new Bibliotheque();
        } else {
            //S'il existe, on est dans le cas de la modification
            $bibliotheque = $bibliothequeRepository->find($id);


            //je controlle que le bien appartient au b bon gestonnaire
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

            //set le user de la personne connecté
            $bibliotheque->setUser($this->getUser());
            //traitement des données
            $entityManager->persist($bibliotheque); //sauvegarde le bien
            $entityManager->flush(); //enregistrer en base

            //message de succés et redirection sur la liste des livres
            $this->addFlash(
                'success',
                'la bibliothèque à bien été édité !'
            );

            return $this->redirectToRoute('app_bibliotheque_liste');
        }

        return $this->render('bibliotheque/editer_bibliotheque.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_voir', requirements: ['id' => '\d+'])]
    public function voir(Bibliotheque $bibliotheque): Response
    {

        return $this->render('bibliotheque/voir_bibliotheque.html.twig', [
            'bibliotheque' => $bibliotheque,
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
            'la bibliothèque a bien été suprimée.');

        return $this->redirectToRoute('app_bibliotheque_liste');
    }

}
