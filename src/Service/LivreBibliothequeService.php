<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class LivreBibliothequeService {

    public function addLivreToBibliotheque (Request $request,
                                            EntityManagerInterface $entityManager,
                                            AuteurRepository $auteurRepository,
                                            int $id = null):Response {

    }
}