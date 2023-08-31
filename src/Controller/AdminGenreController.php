<?php
namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/genre', name: 'app_admin_genre')]
class AdminGenreController extends AbstractController {

    #[Route('/', name: '_liste')]
    public function lister(Request $request,
                           EntityManagerInterface $entityManager,
                           GenreRepository $genreRepository,
                           int $id = null):Response {
        $genre = new Genre();

        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if($form->isSubmitted() /*&& $form->isValid()*/) {
            $entityManager->persist($genre);
            $entityManager->flush();
        }

        $genres = $genreRepository->findAll();

        return $this->render('admin/genre/genre_admin.html.twig', [
            'genres' => $genres,
            'form' => $form,
        ]);
    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request,
                           EntityManagerInterface $entityManager,
                           GenreRepository $genreRepository,
                           int $id = null):Response {
        if($id == null){
            $genre = new Genre();
        }else{
            $genre = $genreRepository->find($id);
        }

        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if($form->isSubmitted() /*&& $form->isValid()*/) {
            $entityManager->persist($genre);
            $entityManager->flush();

            $this->addFlash(
                        'success',
                        'le genre a bien été édité !'
                    );

            return $this->redirectToRoute('app_admin_genre_liste');
        }

        return  $this->render('admin/genre/editer_admin.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function suprimer(EntityManagerInterface $entityManager,
                             GenreRepository $genreRepository,
                             int $id):Response {

        $genre = $genreRepository->find($id);

        $entityManager->remove($genre);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'le genre a bien été suprimé.');

        return  $this->redirectToRoute('app_admin_genre_liste');
    }
}
