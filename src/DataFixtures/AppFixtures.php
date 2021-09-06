<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
    $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        
        $profil = new Profil();
        $profil->setLibelle('ADMIN');

        $user = new User();
        $user->setPrenom('Mamadou')
            ->setNom('Ndiaye')
            ->setEmail('itech.ndaye@gmail.com')
            ->setTelephone('778452214')
            ->setProfil($profil)
            ->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));


        $manager->persist($profil);
        $manager->persist($user);

        $manager->flush();
    }
}
