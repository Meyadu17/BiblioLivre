<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Form\LangueType;
use App\Repository\LangueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/langue', name: 'app_admin_langue')]
class AdminLangueController extends AbstractController
{
    #[Route('/', name: '_liste')]
    public function lister(Request $request,
                            EntityManagerInterface $entityManager,
                            LangueRepository $langueRepository
                            ):Response {
        $langue = new Langue();


        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($langue);
            $entityManager->flush();
        }

        $langues = $langueRepository->findBy([],['libelle' => 'ASC']);

        return $this->render('admin/langue/langue_admin.html.twig', [
            'langues' => $langues,
            'form' => $form,
        ]);
    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request,
                           EntityManagerInterface $entityManager,
                           LangueRepository $langueRepository,
                           int $id = null):Response {
        if($id == null){
            $langue = new Langue();
        }else{
            $langue = $langueRepository->find($id);
        }

        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($langue);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'la langue a bien été éditée !'
            );

            return $this->redirectToRoute('app_admin_langue_liste');
        }

        return  $this->render('admin/langue/editer_admin.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function suprimer(EntityManagerInterface $entityManager,
                             LangueRepository $langueRepository,
                             int $id):Response {

        $langue = $langueRepository->find($id);

        $entityManager->remove($langue);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'la langue a bien été suprimée.');

        return  $this->redirectToRoute('app_admin_langue_liste');
    }
}