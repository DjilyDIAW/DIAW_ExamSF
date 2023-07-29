<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $RH = new User();
        $RH->setNom("");
        $RH->setPrenom("");
        $RH->setPhoto("");
        $RH->setSecteur("");
        $RH->setTypeContrat("");
        $RH->setEmail("rh@humanbooster.com");
        $encodedPassword = $this->hasher->hashPassword($RH, "rh123@");
        $RH->setPassword($encodedPassword);
        $RH->setRoles(["ROLE_RH"]);

         $manager->persist($RH);

        $manager->flush();
    }
}
