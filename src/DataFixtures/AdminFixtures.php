<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Admin();
        $admin->setEmail('admin@admin.com');
        
        $hashedPassword = $this->hasher->hashPassword($admin, 'admin123');
        $admin->setPassword($hashedPassword);

        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        $manager->flush();
    }
}
