<?php

namespace App\DataFixtures;

use App\Entity\Play;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PlayFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 100; $i++) {
            $play = new Play();

            $play->setGame($this->getReference('game_' . rand(0, 5)));
            $play->setUser($this->getReference("user_" . rand(1, 50)));
            $play->setScore(rand(1, 20000));
            $manager->persist($play);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GameFixture::class,
            UserFixtures::class
        ];
    }
}
