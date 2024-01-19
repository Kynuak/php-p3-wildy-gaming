<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class GameFixture extends Fixture implements DependentFixtureInterface
{
    public const GAMES = [
        [
            "name" => "Tétris",
            "category" => "Puzzle",
            "description" => "Tetris est un jeu vidéo de puzzle conçu par l'ingénieur soviétique Alekseï Pajitnov 
            à partir de juin 1984 sur Elektronika 60. 
            Lors de la création du concept, Pajitnov est aidé de Dmitri Pavlovski et 
            Vadim Guerassimov pour le développement. 
            Le jeu est édité par plusieurs sociétés au cours du temps, à la suite d'une guerre pour 
            l'appropriation des droits à la fin des années 1980. 
            Le déroulement précis du développement et des premières commercialisations est encore 
            débattu dans les années 2010. 
            Après une exploitation importante par Nintendo, les droits appartiennent depuis 1996 à la 
            société The Tetris Company."
        ],
        [
            "name" => "Pacman",
            "category" => "Arcade",
            "description" => "Pac-Man (パックマン, Pakkuman?) est une série de jeux vidéo créée par Tōru Iwatani et 
            éditée par Namco. Elle a débuté en 1980 avec le jeu éponyme."
        ],
        [
            "name" => "Space Invader",
            "category" => "Shoot'em up",
            "description" => "Invader est un artiste de rue et mosaïste français, né en France en 1969. 
            Il installe depuis 1996 une série de Space Invaders, réalisés en mosaïques, sur 
            les murs de grandes métropoles internationales."
        ],
        [
            "name" => "Tic-Tac-Toe",
            "category" => "Réflexion",
            "description" => "Le tic-tac-toe, aussi appelé « morpion » (par analogie avec le jeu de morpion) 
            et « oxo » en Belgique, est un jeu de réflexion 
            se pratiquant à deux joueurs, tour par tour, dont le but est de créer le premier un alignement. 
            Le jeu se joue généralement en dessinant sur papier au crayon."
        ],
        [
            "name" => "Jeu de paires",
            "category" => "Réflexion",
            "description" => "Le jeu se compose de paires de cartes portant des illustrations identiques. 
            L'ensemble des cartes est mélangé, puis étalé face contre table. À son tour, chaque joueur 
            retourne deux cartes de son choix. 
            S'il découvre deux cartes identiques, il les ramasse et les conserve, ce qui lui permet de rejouer. 
            Si les cartes ne sont pas identiques, 
            il les retourne faces cachées à leur emplacement de départ."
        ],
        [
            "name" => "Snake",
            "category" => "Arcade",
            "description" => "Le snake, de l'anglais signifiant « serpent », 
            est un genre de jeu vidéo dans lequel le joueur 
            dirige un serpent qui grandit et constitue ainsi lui-même un obstacle. 
            Bien que le concept tire son origine du jeu vidéo d'arcade Blockade, 
            il n'existe pas de version standard. 
            Son concept simple l'a amené à être porté sur l'ensemble des plates-formes 
            de jeu existantes sous des noms de clone."
        ]
    ];

    public function __construct(private SluggerInterface $slugger)
    {
    }


    public function load(ObjectManager $manager): void
    {
        foreach (self::GAMES as $key => $gameValue) {
            $game = new Game();
            $game->setName($gameValue["name"]);
            $slug = $this->slugger->slug($gameValue["name"]);
            $game->setSlug($slug);
            $game->setDescription($gameValue["description"]);
            $game->setIsAvailable(true);
            $game->setCategory($this->getReference("category_" . $gameValue['category']));
            $this->addReference("game_" . $key, $game);

            $manager->persist($game);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
