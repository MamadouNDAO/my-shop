<?php

namespace App\Model;

use App\Entity\User;
use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    protected $em;
    protected $encoder;
    protected $validator;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->validator = $validator;
    }

    public function ajoutUser($data)
    {
        $user = new User();
        $user->setPrenom($data['prenom']);
        $user->setNom($data['nom']);
        $verifEmail = $this->em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if($verifEmail){
            return array("status" => false, "code" => 500, "message" => "Cet email est déjà utilisé");
        }
        $user->setEmail($data['email']);
        $telephone = $data['telephone'] ?? null;
        $user->setTelephone($telephone);
        $password = $this->encoder->encodePassword($user, 'passer123');
        $user->setPassword($password);

        //Je récupére le profil dans la base de données
        $profil = $this->em->getRepository(Profil::class)->find($data['idProfil']);

        //Je vérifie si le profil est bon
        if(!$profil){
            return array("status" => false, "code" => 500, "message" => "Id profil invalide");
        }

        //Si le profil est bon, je relie l'utilisateur au profil donné
        $user->setProfil($profil);

        //Je fais la validation 
        $errors = $this->validator->validate($user);

        if(count($errors) > 0){
            $errorsString = (string) $errors;
            return array("status" => false, "code" => 500, "data" => $errorsString);
        }

        $this->em->persist($user);
        $this->em->flush();
        return array("status" => true, "code" => 201, "message" => "Utilisateur créé avec succès");
    }
}