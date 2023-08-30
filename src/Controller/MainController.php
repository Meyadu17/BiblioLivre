<?php

namespace App\Controller;

use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        //Création en dur d'un livre :
        $livre1 = new stdClass();
        $livre1->cycle ="Le seigneur des anneaux";
        $livre1->tome ="1";
        $livre1->nom ="La communauté de l'anneau";
        $livre1->auteur ="J. R. Tolkien";
        $livre1->langue ="Français";
        $livre1->genre ="Fantastique";
        $livre1->editeur ="Pocket";
        $livre1->isbn ="2266282360";
        $livre1->resume ="'Anneau de Pouvoir, forgé par Sauron au cœur de la Montagne du Feu, dépositaire de son sombre pouvoir, est perdu. Nul ne sait ce qu'il est devenu depuis qu'un homme l'a arraché de la main du Seigneur Sombre et, ainsi, put chasser ce dernier hors du monde. Mais de noirs présages s'étendent à nouveau sur la Terre du Milieu, les créatures maléfiques se multiplient et, dans les Montagnes de Brume, les Orques traquent les Nains. L'ennemi veut récupérer son bien, son Maître le cherche partout et l'œil de Sauron est désormais pointé sur le Comté. Heureusement Gandalf le Gris les a devancés, s'ils font vite, lui et le petit Frodo parviendront peut-être à détruire l'Anneau à temps...";

        $livre2 = new stdClass();
        $livre2->cycle ="Le seigneur des anneaux";
        $livre2->tome ="2";
        $livre2->nom ="Les deux tours";
        $livre2->auteur ="J. R. Tolkien";
        $livre2->langue ="Français";
        $livre2->genre ="Fantastique";
        $livre2->editeur ="Pocket";
        $livre2->isbn ="2266282379";
        $livre2->resume ="Les neux compagnons avaient fondé la Fraternité de l'Anneau, tous soudés autour de Frodo, dépositaire de l'Anneau de Pouvoir, chargé de le détruire en le jetant dans la Montagne du Feu, où il fut forgé par son maître.
        Mais c'est là une quête terrible et semée d'embûches. Leur guide, Gandalf, a disparu, Boromir, comme pris de folie, a voulu s'emparer de l'Anneau, Frodo a dû s'échapper et poursuit, esseulé, mais déterminé, son voyage jusqu'au cœur du Mordor. La Fraternité est dissoute, les Ténèbres s'étendent toujours plus, et l'avenir de la Terre du Millieu repose sur les frêles épaules d'un courageux petit Hobbit.";
        
        $livres[] = [$livre1, $livre2];

        return $this->render('main/index.html.twig', [
            'controller_name' => 'Livres',
            "livre1" => $livre1,
            "livre2" => $livre2,
            "livres" => $livres,
        ]);
    }
}
