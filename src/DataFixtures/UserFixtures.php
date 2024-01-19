<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $user = new User();
            $user->setEmail("gamer" . $i . "@gamer.fr");
            $user->setRoles(["ROLE_GAMER"]);
            $user->setUsername("gamer" . $i);
            $passwordUser = "gamer" . $i;
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $passwordUser
            );
            $user->setPassword($hashedPassword);
            $this->addReference('user_' . $i, $user);

            $manager->persist($user);
        }

        $manager->flush();


        $user = new User();

        $user->setEmail("admin@admin.fr");
        $user->setRoles(["ROLE_ADMIN"]);
        $passwordUser = "admin";
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $passwordUser
        );

        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $manager->flush();
    }
}
