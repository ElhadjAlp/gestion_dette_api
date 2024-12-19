<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\User;
use App\Entity\Dette;
use App\Entity\Article;
use App\Entity\Payment;
use App\Entity\Detail;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création de 10 clients fictifs avec une boucle
        for ($i = 1; $i <= 10; $i++) {
            // Création d'un client
            $client = new Client();
            $client->setSurname('Client ' . $i);
            $client->setTelephone('0' . rand(100000000, 999999999));
            $client->setAdresse('Adresse ' . $i . ' rue de test');
            
            // Persist chaque client
            $manager->persist($client);

            // Création d'un utilisateur associé à chaque client
            $user = new User();
            $user->setLogin('user' . $i);
            $user->setPassword('password' . $i);
            $user->setEmail('email' . $i);
             // N'oubliez pas de hacher le mot de passe en production
            $user->setRoles(['ROLE_USER']); // Assurez-vous que ce rôle existe dans votre code
            $user->setClient($client);  // Lier le User au Client (relation OneToOne)

            // Persist chaque utilisateur
            $manager->persist($user);

            // Associer des dettes à chaque client
            for ($j = 1; $j <= 3; $j++) {
                $dette = new Dette();
                $dette->setMontant(rand(100, 1000));  // Montant aléatoire entre 100 et 1000
                $dette->setMontantVerser(rand(0, 500));  // Montant versé aléatoire
                $dette->setMontantRestant($dette->getMontant() - $dette->getMontantVerser()); // Calcul du montant restant
                $dette->setClient($client);  // Lier la dette au client (relation OneToMany)

                // Persist chaque dette
                $manager->persist($dette);

                // Création d'articles pour chaque dette
                $articles = [];  // Tableau pour stocker les articles de cette dette
                for ($k = 1; $k <= 2; $k++) {
                    $article = new Article();
                    $article->setLibelle('Article ' . $k);
                    $article->setReference('Reference de l\'article ' . $k);
                    $article->setQteStock($k);
                    $article->setPrix(rand(10, 200)); // Prix aléatoire entre 10 et 200

                    // Persist chaque article
                    $manager->persist($article);

                    // Ajouter l'article à la liste des articles associés à la dette
                    $articles[] = $article;
                }

                // Ajouter des paiements associés à la dette
                for ($k = 1; $k <= 2; $k++) {
                    $payment = new Payment();
                    $payment->setMontant(rand(10, 500));  // Montant du paiement entre 10 et 500
                    $payment->setDate(new \DateTimeImmutable());  // Date actuelle
                    $payment->setYes($dette);  // Associer le paiement à la dette

                    // Persist chaque paiement
                    $manager->persist($payment);

                    // Ajouter des détails pour chaque paiement
                    foreach ($articles as $article) {  // Utiliser les articles créés précédemment
                        for ($l = 1; $l <= 2; $l++) {
                            $detail = new Detail();
                            $detail->setPrixVente(rand(5, 100));        
                            $detail->setQteVendu($l);
                            $detail->setArticle($article);  // Associer l'article au détail
                            $detail->setDette($dette);  // Associer le détail à la dette

                            // Persist chaque détail
                            $manager->persist($detail);
                        }
                    }
                }
            }
        }

        // Sauvegarder toutes les entités en base de données
        $manager->flush();
    }
}
