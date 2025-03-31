<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Ajouter un admin
        $admin = new User();
        $admin->setUsername('admin')
            ->setFirstname('admin')
            ->setLastname('admin')
            ->setEmail('admin@example.com')
            ->setPassword($this->hasher->hashPassword($admin, 'admin123'))
            ->setRoles(['ROLE_ADMIN']); // Rôle sous forme de tableau
        //   ->setCreatedAt(new \DateTime())
        //   ->setUpdatedAt(new \DateTime());

        $manager->persist($admin);

        // Ajouter un utilisateur
        $user = new User();
        $user->setUsername('johndoe')
            ->setFirstname('bliblablou')
            ->setLastname('kevin')
            ->setEmail('johndoe@example.com')
            ->setPassword($this->hasher->hashPassword($user, 'password'))
            ->setRoles(['ROLE_USER']); // Rôle sous forme de tableau
        //  ->setCreatedAt(new \DateTime())
        //  ->setUpdatedAt(new \DateTime());

        $manager->persist($user);

        $manager->flush();
    }
}
