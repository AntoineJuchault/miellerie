<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UsersFixtures extends Fixture
{   

    function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger
    ){}

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
            $admin = new Users();
            $admin->setEmail('admin@miellerie.fr');
            $admin->setLastname('Tijuana');
            $admin->setFirstname('Tijuana');
            $admin->setAddress('#');
            $admin->setZipcode('#');
            $admin->setCity('Paris');
            $admin->setPassword($this->passwordEncoder->hashPassword($admin, '123456789'));
            $admin->setRoles(['ROLE_ADMIN']);

            $manager->persist($admin);
        $manager->flush();
    }
}
