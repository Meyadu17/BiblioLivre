<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Bibliotheque;
use App\Entity\Edition;
use App\Entity\Genre;
use App\Entity\Langue;
use App\Entity\Livre;
use App\Entity\User;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        // ------------ USER ------------

        $user = new User();
        $user->setPseudo("Titi");
        $user->setEmail("titi@admin.fr");
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                "admin"
            )
        );
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        $user2 = new User();
        $user2->setPseudo("Vincent");
        $user2->setEmail("vincent@gmail.fr");
        $user2->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user2,
                "vincent"
            )
        );
        $manager->persist($user2);

        // ------------ AUTEUR ------------
        $auteur = new Auteur();
        $auteur->setNom("Tolkien");
        $auteur->setPrenom("J. R. R.");
        $manager->persist($auteur);

        $auteur2 = new Auteur();
        $auteur2->setNom("Rolling");
        $auteur2->setPrenom("J. K.");
        $manager->persist($auteur2);

        // ------------ GENRE ------------
        $genre = new Genre();
        $genre->setLibelle("Fantastique");
        $manager->persist($genre);

        // ------------ LANGUE ------------
        $langue = new Langue();
        $langue->setCode("FR");
        $langue->setLibelle("Français");
        $manager->persist($langue);

        // ------------ EDITION ------------
        $edition = new Edition();
        $edition->setLibelle("Pocket");
        $manager->persist($edition);

        // ------------ LIVRE ------------
        $livre = new Livre();
        $livre->setCycle("Le seigneur des anneaux");
        $livre->setTome("1");
        $livre->setLangue($langue);
        $livre->setEdition($edition);
        $livre->setIsbn($faker->isbn10);
        $livre->setResume($faker->paragraph);
        $livre->addAuteur($auteur);
        $livre->addGenre($genre);
        $manager->persist($livre);

        $livre = new Livre();
        $livre->setCycle("Harry potter");
        $livre->setTome("1");
        $livre->setTitre("A l'ecole des sorciers");
        $livre->setLangue($langue);
        $livre->setEdition($edition);
        $livre->setIsbn($faker->isbn10);
        $livre->setResume($faker->paragraph);
        $livre->addAuteur($auteur2);
        $livre->addGenre($genre);
        $manager->persist($livre);

        // ------------ BIBLIOTHEQUE ------------
        $bibliotheque = new Bibliotheque();
        $bibliotheque->setUser($user);
        $bibliotheque->setNom("La biblio");
        $manager->persist($bibliotheque);

        $bibliotheque2 = new Bibliotheque();
        $bibliotheque2->setUser($user2);
        $bibliotheque2->setNom("mes livres");
        $manager->persist($bibliotheque2);

        $manager->flush();
    }
}
