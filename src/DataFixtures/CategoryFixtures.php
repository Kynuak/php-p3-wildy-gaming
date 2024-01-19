<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        "Réflexion",
        "Shoot'em up",
        "Puzzle",
        "Arcade",
    ];

    public function load(ObjectManager $manager): void
    {

        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference("category_" . $categoryName, $category);
        }

        $manager->flush();
    }
}
