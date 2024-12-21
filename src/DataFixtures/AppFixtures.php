<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) { }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@example.com');
        $user->setIsVerified(true);
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $password = $this->hasher->hashPassword($user, 'super_secret_password');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}
