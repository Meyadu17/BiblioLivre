<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/livre', name: 'app_main')]
class MainController extends AbstractController{

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

        return $this->render('main/index.html.twig', [
            'livres' => $livres,
            'bibliotheques' => $bibliotheques,
        ]);
    }
    #[Route('/{id}', name: '_voir', requirements: ['id' => '\d+'])]
    public function voir(Livre $livre):Response {

        return  $this->render('main/voir_livre.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/meslivres', name: '_livres')]
    public function mesLivres(LivreRepository $livreRepository): Response
    {
        $livres = $livreRepository->findAll();

        return $this->render('main/mes_livres.html.twig', [
            'livres' => $livres,
        ]);
    }

    #[Route('/travaux', name: '_travaux')]
    public function travaux(): Response
    {
        return $this->render('main/en_travaux.html.twig', [
            'travaux' => 'MainController',
        ]);
    }

    #[Route('/mentions', name: '_mentions')]
    public function mentionsLegales(): Response
    {
        return $this->render('main/mentions_legales.html.twig', [
            'mentions' => 'MainController',
        ]);
    }
}
