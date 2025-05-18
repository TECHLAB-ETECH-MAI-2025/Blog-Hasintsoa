<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        $categoriesData = [
            [
                'title' => 'Intelligence Artificielle',
                'description' => 'Articles explorant les développements, les applications et les implications de l\'intelligence artificielle dans divers domaines.',
            ],
            [
                'title' => 'Changement Climatique',
                'description' => 'Articles analysant les causes, les effets et les solutions potentielles au changement climatique mondial.',
            ],
            [
                'title' => 'Santé Mentale',
                'description' => 'Articles abordant les aspects du bien-être psychologique, les troubles mentaux et les stratégies pour une bonne santé mentale.',
            ],
            [
                'title' => 'Énergies Renouvelables',
                'description' => 'Articles examinant les différentes sources d\'énergie renouvelable, leurs technologies et leur rôle dans la transition énergétique.',
            ],
            [
                'title' => 'Exploration Spatiale',
                'description' => 'Articles relatant les découvertes, les missions et les ambitions de l\'exploration de l\'espace.',
            ],
            [
                'title' => 'Économie Numérique',
                'description' => 'Articles analysant l\'impact des technologies numériques sur l\'économie et les modèles commerciaux.',
            ],
            [
                'title' => 'Patrimoine Culturel',
                'description' => 'Articles mettant en lumière l\'importance de la préservation du patrimoine culturel à travers le monde.',
            ],
            [
                'title' => 'Alimentation Durable',
                'description' => 'Articles explorant les pratiques agricoles et alimentaires qui favorisent la durabilité environnementale et la santé.',
            ],
            [
                'title' => 'Neurosciences',
                'description' => 'Articles présentant les dernières découvertes sur le fonctionnement du cerveau et du système nerveux.',
            ],
            [
                'title' => 'Océans et Biodiversité Marine',
                'description' => 'Articles traitant des enjeux liés à la santé des océans et à la conservation de la vie marine.',
            ]
        ];
        $categories = [];
        foreach ($categoriesData as $data) {
            $category = (new Category())
                ->setTitle($data['title'])
                ->setDescription($data['description'])
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisYear("now")));
            $manager->persist($category);
            $categories[$data['title']] = $category;
        }

        $ArticlesData = [
            [
                'title' => 'L\'impact transformateur de l\'IA sur les industries créatives',
                'categories' => ['Intelligence Artificielle', 'Technologie', 'Culture'],
            ],
            [
                'title' => 'Les records de température mondiale soulignent l\'urgence de l\'action climatique',
                'categories' => ['Changement Climatique', 'Environnement', 'Science'],
            ],
            [
                'title' => 'Stratégies efficaces pour gérer l\'anxiété au quotidien',
                'categories' => ['Santé Mentale', 'Bien-être', 'Psychologie', 'Conseils pratiques'],
            ],
            [
                'title' => 'Les dernières innovations dans le domaine de l\'énergie solaire photovoltaïque',
                'categories' => ['Énergies Renouvelables', 'Technologie', 'Environnement'],
            ],
            [
                'title' => 'La prochaine génération de télescopes spatiaux et leurs objectifs scientifiques',
                'categories' => ['Exploration Spatiale', 'Science', 'Technologie'],
            ],
            [
                'title' => 'Comment la blockchain révolutionne les chaînes d\'approvisionnement mondiales',
                'categories' => ['Économie Numérique', 'Technologie', 'Économie'],
            ],
            [
                'title' => 'Les sites du patrimoine mondial en péril face aux conflits et au changement climatique',
                'categories' => ['Patrimoine Culturel', 'Histoire', 'Environnement'],
            ],
            [
                'title' => 'Les avantages des régimes alimentaires à base de plantes pour la santé et la planète',
                'categories' => ['Alimentation Durable', 'Santé', 'Environnement'],
            ],
            [
                'title' => 'Les découvertes récentes sur la plasticité du cerveau humain à l\'âge adulte',
                'categories' => ['Neurosciences', 'Science', 'Psychologie'],
            ],
            [
                'title' => 'L\'impact de la pollution plastique sur les écosystèmes marins',
                'categories' => ['Océans et Biodiversité Marine', 'Environnement', 'Science'],
            ],
            [
                'title' => 'Les implications éthiques des véhicules autonomes sur la société',
                'categories' => ['Intelligence Artificielle', 'Technologie', 'Société'],
            ],
            [
                'title' => 'Les solutions innovantes pour l\'adaptation aux inondations côtières',
                'categories' => ['Changement Climatique', 'Environnement', 'Villes'],
            ],
            [
                'title' => 'L\'importance de la méditation pour améliorer la concentration et la productivité',
                'categories' => ['Santé Mentale', 'Bien-être', 'Conseils pratiques'],
            ],
            [
                'title' => 'Le potentiel de l\'énergie géothermique profonde comme source d\'énergie durable',
                'categories' => ['Énergies Renouvelables', 'Environnement', 'Science'],
            ],
            [
                'title' => 'Les défis et les opportunités de la colonisation de Mars',
                'categories' => ['Exploration Spatiale', 'Science', 'Technologie'],
            ],
            [
                'title' => 'L\'essor des plateformes de financement participatif pour les projets créatifs',
                'categories' => ['Économie Numérique', 'Économie', 'Arts'],
            ],
            [
                'title' => 'La préservation des langues minoritaires : un enjeu culturel mondial',
                'categories' => ['Patrimoine Culturel', 'Société', 'Culture'],
            ],
            [
                'title' => 'Les techniques d\'agriculture régénératrice pour restaurer la santé des sols',
                'categories' => ['Alimentation Durable', 'Environnement', 'Agriculture'],
            ],
            [
                'title' => 'Les dernières recherches sur le rôle du microbiome intestinal dans la santé humaine',
                'categories' => ['Neurosciences', 'Santé', 'Science'],
            ],
            [
                'title' => 'Les efforts internationaux pour la conservation des récifs coralliens',
                'categories' => ['Océans et Biodiversité Marine', 'Environnement', 'Nature'],
            ],
        ];
        foreach ($ArticlesData as $articleData) {
            $article = (new Article())
                ->setTitle($articleData['title'])
                ->setContent($faker->paragraphs(3, true))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisYear("now")));
            foreach ($articleData['categories'] as $categoryName) {
                if (isset($categories[$categoryName]))
                    $article->addCategory($categories[$categoryName]);
            }
            $comments = [];
            for ($i = 0; $i <= $faker->numberBetween(1, 3); $i++) {
                $comment = (new Comment())
                    ->setAuthor($faker->userName())
                    ->setContent($faker->paragraph())
                    ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisYear("now")));
                $manager->persist($comment);
                $article->addComment($comment);
            }
            $manager->persist($article);
        }

        $manager->flush();
    }
}
