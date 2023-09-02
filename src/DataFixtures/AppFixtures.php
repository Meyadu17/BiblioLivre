<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Edition;
use App\Entity\Genre;
use App\Entity\Langue;
use App\Entity\Livre;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        $auteur = new Auteur();
        $auteur->setNom($faker->lastName);
        $auteur->setPrenom($faker->name);
        $manager->persist($auteur);

        $genre = new Genre();
        $genre->setLibelle($faker->words);
        $manager->persist($genre);

        $langue = new Langue();
        $langue->setCode("FR");
        $langue->setLibelle("Français");
        $manager->persist($langue);

        $edition = new Edition();
        $edition->setLibelle($faker->words);
        $manager->persist($edition);

        $livre = new Livre();
        $livre->setCycle($faker->sentence());
        $livre->setTome($faker->randomDigit);
        $livre->setTitre($faker->sentence());
        $livre->setLangue($langue);
        $livre->setEdition($edition);
        $livre->setIsbn($faker->isbn10);
        $livre->setResume($faker->paragraph);
        $livre->addAuteur($auteur);
        $livre->addGenre($genre);
        $manager->persist($livre);

        $manager->flush();
    }
}
