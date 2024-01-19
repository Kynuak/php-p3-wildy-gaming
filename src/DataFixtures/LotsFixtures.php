<?php

namespace App\DataFixtures;

use App\Entity\Lot;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LotsFixtures extends Fixture
{
    public const TITLES = [
        ['title' => 'Porte clés', 'image' => 'porte-cle.jpg'],
        ['title' => 'Pins', 'image' => 'pins.webp'],
        ['title' => 'Mug', 'image' => 'mug.jpg'],
        ['title' => 'Casquette', 'image' => 'casquette.jpg'],
        ['title' => 'Peluches', 'image' => 'peluches.jpg'],
        ['title' => 'Lampe', 'image' => 'lampe-manette-xbox2.jpg'],
        ['title' => 'Mini borne d\'arcade', 'image' => 'mini_borne_arcade.jpg'],
        ['title' => 'Réveil', 'image' => 'reveil-manette-ps1.jpg'],
        ['title' => 'POP', 'image' => 'POP-h.jpg'],
        ['title' => 'Clavier', 'image' => 'clavier1.webp'],
        ['title' => 'Souris', 'image' => 'souris1.jpg'],
        ['title' => 'Casque', 'image' => 'casque-gamer.jpg'],
        ['title' => 'Tapis de souris XL', 'image' => 'tapis-de-souris.jpg'],
        ['title' => 'PS5', 'image' => 'ps5.jpg'],
        ['title' => 'Xbox série X', 'image' => 'Xbox.jpg'],
        ['title' => 'Smartphone', 'image' => 'smartphone.webp'],
        ['title' => 'PC portable', 'image' => 'pc.jpg'],
    ];

    public const PRICES = [
        67,
        911,
        2010,
        4038,
        10001,
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
            $lot->setPrice(self::PRICES[
                rand(0, count(self::PRICES) - 1)
                ]);
            $lot->setImage($gift['image']);

            $manager->persist($lot);
        }
        $manager->flush();
    }
}
