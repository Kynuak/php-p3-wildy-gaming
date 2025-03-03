<?php

namespace App\DataFixtures;

use App\Entity\Lot;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LotsFixtures extends Fixture
{
    public const TITLES = [
        ['title' => 'Porte clés', 'image' => 'porte-cle.jpg', 'palier' => 50],
        ['title' => 'Pins', 'image' => 'pins.webp', 'palier' => 50],
        ['title' => 'Mug', 'image' => 'mug.jpg', 'palier' => 50],
        ['title' => 'Casquette', 'image' => 'casquette.jpg', 'palier' => 250],
        ['title' => 'Peluches', 'image' => 'peluches.jpg', 'palier' => 250],
        ['title' => 'Lampe', 'image' => 'lampe-manette-xbox2.jpg', 'palier' => 450],
        ['title' => 'Mini borne d\'arcade', 'image' => 'mini_borne_arcade.jpg', 'palier' => 250],
        ['title' => 'Réveil', 'image' => 'reveil-manette-ps1.jpg', 'palier' => 450],
        ['title' => 'POP', 'image' => 'POP-h.jpg', 'palier' => 450],
        ['title' => 'Clavier', 'image' => 'clavier1.webp', 'palier' => 650],
        ['title' => 'Souris', 'image' => 'souris1.jpg', 'palier' => 650],
        ['title' => 'Casque', 'image' => 'casque-gamer.jpg', 'palier' => 650],
        ['title' => 'Tapis de souris XL', 'image' => 'tapis-de-souris.jpg', 'palier' => 250],
        ['title' => 'PS5', 'image' => 'ps5.jpg', 'palier' => 850],
        ['title' => 'Xbox série X', 'image' => 'Xbox.jpg', 'palier' => 850],
        ['title' => 'Smartphone', 'image' => 'smartphone.webp', 'palier' => 650],
        ['title' => 'PC portable', 'image' => 'pc.jpg', 'palier' => 850],
    ];

    public const PRICES = [
        50,
        250,
        450,
        650,
        850,
    ];

    public function load(ObjectManager $manager): void
    {
        $uploadLotDir = '/uploads/lot';
        if (!is_dir(__DIR__ . '/../../public' . $uploadLotDir)) {
            mkdir(__DIR__ . '/../../public' . $uploadLotDir, recursive: true);
        }

        foreach (self::TITLES as $gift) {
            copy(
                __DIR__ . '/data/lot/' . $gift['image'],
                __DIR__ . '/../../public' . $uploadLotDir . '/' . $gift['image']
            );
            $lot = new Lot();
            $lot->setTitle($gift['title']);
            // $lot->setPrice(self::PRICES[
            //     rand(0, count(self::PRICES) - 1)
            //     ]);
            $lot->setPrice($gift['palier']);
            $lot->setImage($gift['image']);

            $manager->persist($lot);
        }
        $manager->flush();
    }
}
