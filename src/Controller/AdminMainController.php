<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\AddLivreToBibliothequeType;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use App\Service\UploadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/livre', name: 'app_admin_main')]
class AdminMainController extends AbstractController
{
    #[Route('/', name: '_liste')]
    public function lister(LivreRepository $livreRepository): Response
    {
        $user = $this->getUser();
        //récupérer les bibliothèques associées à cet utilisateur
        if ($user) {
            $bibliotheques = $user->getBibliotheques();
        } else {
            return $this->redirectToRoute('app_login');
        }
        $livres = $livreRepository->findBy([],['cycle' => 'ASC']);

        return $this->render('admin/main/main_admin.html.twig', [
            'livres' => $livres,
            'bibliotheques' => $bibliotheques,
        ]);

    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request, 
                           EntityManagerInterface $entityManager,
                           LivreRepository $livreRepository,
                           UploadService $uploadService,
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

            //Upload de l'image
            if($form->get('couverture')->getData()) {
                $newFilename = $uploadService->upload($form->get('couverture')->getData(), $this->getParameter('couvertures_directory'));
                $livre->setCouverture($newFilename);
            }
            //traitement des données
            $entityManager->persist($livre); //sauvegarde le bien
            $entityManager->flush(); //enregistrer en base
            
            //message de succés et redirection sur la liste des livres
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

    #[Route('/{id}', name: '_voir', requirements: ['id' => '\d+'])]
    public function voir(Livre $livre):Response {

        return  $this->render('admin/main/voir_livre_admin.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/rechercher', name: '_rechercher')]
    public function rechercher(Request $request, LivreRepository $livreRepository): Response
    {
        $searchTerm = $request->query->get('q'); // Récupérez le terme de recherche depuis la requête GET

        $livres = $livreRepository->searchLivres($searchTerm);

        return $this->render('admin/main/main_admin.html.twig', [
            'livres' => $livres,
        ]);
    }

    #[Route('/admin/livre/ajouter-a-bibliotheque/{id}', name: '_ajouter_a_bibliotheque')]
    public function ajouterALaBibliotheque(Request $request,
                                           EntityManagerInterface $entityManager,
                                           Livre $livre): Response
    {
        $form = $this->createForm(AddLivreToBibliothequeType::class, $livre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bibliotheque = $form->get('bibliotheque')->getData();

            // Ajoutez le livre à la bibliothèque
            $bibliotheque->addLivre($livre);
            $entityManager->persist($bibliotheque); //sauvegarde le bien
            $entityManager->flush(); //enregistrer en base

            //$this->getDoctrine()->getManager()->flush();

            // Redirigez ou renvoyez une réponse JSON en fonction de vos besoins
        }

        return $this->render('admin/main/ajouter_a_bibliotheque.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
