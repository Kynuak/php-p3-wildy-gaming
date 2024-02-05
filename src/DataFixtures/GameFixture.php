<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;
use Symfony\Component\String\Slugger\SluggerInterface;

class GameFixture extends Fixture implements DependentFixtureInterface
{
    public const GAMES = [
        [
            "name" => "Snake",
            "category" => "Arcade",
            "description" => "Le snake, de l'anglais signifiant « serpent », 
            est un genre de jeu vidéo dans lequel le joueur 
            dirige un serpent qui grandit et constitue ainsi lui-même un obstacle. 
            Bien que le concept tire son origine du jeu vidéo d'arcade Blockade, 
            il n'existe pas de version standard. 
            Son concept simple l'a amené à être porté sur l'ensemble des plates-formes 
            de jeu existantes sous des noms de clone.",
            "image" => "snake.png"
        ],
        [
            "name" => "Planet Defense",
            "category" => "Shoot'em up",
            "description" => "Jeu de tir spatial, le vaisseau doit défendre la planète contre
            des astéroïdes.",
            "image" => "planet-defense.png"
        ],
        [
            "name" => "Pac-man",
            "category" => "Arcade",
            "description" => "Pac-Man (パックマン, Pakkuman?) est une série de jeux vidéo créée par Tōru Iwatani et 
            éditée par Namco. Elle a débuté en 1980 avec le jeu éponyme.",
            "image" => "pac-man.png"
        ],
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
            société The Tetris Company.",
            "image" => ""
        ],
        [
            "name" => "Space Invader",
            "category" => "Shoot'em up",
            "description" => "Invader est un artiste de rue et mosaïste français, né en France en 1969. 
            Il installe depuis 1996 une série de Space Invaders, réalisés en mosaïques, sur 
            les murs de grandes métropoles internationales.",
            "image" => ""
        ],

    ];

    public function __construct(private SluggerInterface $slugger)
    {
    }


    public function load(ObjectManager $manager): void
    {
        foreach (self::GAMES as $key => $gameValue) {
            $game = new Game();
            $game->setName($gameValue["name"]);
            $game->setImage($gameValue['image']);
            $slug = $this->slugger->slug($gameValue["name"]);
            $game->setSlug(strtolower($slug));
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
