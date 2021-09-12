<?php

namespace App\Model;

use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;

class ProfilManager
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    public function ajoutProfil($data)
    {
        if(!isset($data['libelle'])){
            
            return array("status" => false, "code" => 500, "message" => "Le libellé est obligatoire");

        }

        $profil = new Profil();
        $profil->setLibelle($data['libelle']);
        $this->em->persist($profil);
        $this->em->flush();

        return array("status" => true, "code" => 201, "message" => "Profil créé avec succès");
    }
}