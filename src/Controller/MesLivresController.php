<?php

namespace App\Controller;

use App\Repository\LivreUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/meslivres', name: 'app_mes_livres')]
class MesLivresController extends AbstractController
{
    #[Route('/liste', name: '_liste')]
    public function index(LivreUserRepository $livreUserRepository): Response
    {
        $livreUsers = $livreUserRepository->findAll();

        return $this->render('mes_livres/index.html.twig', [
            'livreUsers' => $livreUsers,
        ]);
    }
}
