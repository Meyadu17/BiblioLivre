<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/main', name: 'app_main')]
class MainController extends AbstractController{
    
    #[Route('/', name: '_liste')]
    public function lister(LivreRepository $livreRepository): Response
    {
        $livres = $livreRepository->findAll();

        return $this->render('main/index.html.twig', [
            'livres' => $livres,
        ]);
    }
    #[Route('/{id}', name: '_voir', requirements: ['id' => '\d+'])]
    public function voir(Livre $livre):Response {

        return  $this->render('main/voir_livre.html.twig', [
            'livre' => $livre,
        ]);
    }
}
