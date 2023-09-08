<?php

namespace App\Controller;

use App\Service\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {

        return $this->render('profil/index.html.twig');
    }

    #[Route('/profil/modifier', name: 'app_profil_modifier')]
    public function modifier(UploadService $uploadService): Response
    {
        //TODO modifier profil

        return $this->render('index.html.twig');
    }
}
