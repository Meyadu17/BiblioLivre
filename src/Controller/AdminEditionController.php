<?php

namespace App\Controller;

use App\Entity\Edition;
use App\Form\EditionType;
use App\Repository\EditionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/editeur', name: 'app_admin_edition')]
class AdminEditionController extends AbstractController
{
    #[Route('/', name: '_liste')]
    public function lister(Request $request,
                           EntityManagerInterface $entityManager,
                           EditionRepository $editionRepository
    ):Response {
        $edition = new Edition();

        $form = $this->createForm(EditionType::class, $edition);
        $form->handleRequest($request);

        if($form->isSubmitted() /*&& $form->isValid()*/) {
            $entityManager->persist($edition);
            $entityManager->flush();
        }

        $edition = $editionRepository->findAll();

        return $this->render('admin/edition/edition_admin.html.twig', [
            'editions' => $edition,
            'form' => $form,
        ]);
    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request,
                           EntityManagerInterface $entityManager,
                           EditionRepository $editionRepository,
                           int $id = null):Response {
        if($id == null){
            $edition = new Edition();
        }else{
            $edition = $editionRepository->find($id);
        }

        $form = $this->createForm(EditionType::class, $edition);
        $form->handleRequest($request);

        if($form->isSubmitted() /*&& $form->isValid()*/) {
            $entityManager->persist($edition);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'l\édition a bien été édité !'
            );

            return $this->redirectToRoute('app_admin_edition_liste');
        }

        return  $this->render('admin/edition/editer_admin.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function suprimer(EntityManagerInterface $entityManager,
                             EditionRepository $editionRepository,
                             int $id):Response {

        $edition = $editionRepository->find($id);

        $entityManager->remove($edition);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'l\édition a bien été suprimé.');

        return  $this->redirectToRoute('app_admin_edition_liste');
    }
}
