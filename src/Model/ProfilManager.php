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

    public function updateProfil($data, $id)
    {
        $profil = $this->em->getRepository(Profil::class)->find($id);
        if(!$profil){
            return array("status" => false, "code" => 500, "message" => 'Id profil invalide');
        }
        if(!isset($data['libelle']) || $data['libelle'] == ''){
            return array("status" => false, "code" => 500, "message" => "Le libellé est obligatoire");
        }

        $profil->setLibelle($data['libelle']);
        $this->em->flush();
        return array("status" => true, "code" => 201, "message" => "Profil modifié avec succès");
    }

    public function listProfil()
    {
        $profils = $this->em->getRepository(Profil::class)->findAll();
        $datas = [];
        foreach($profils as $profil){
            $data['id'] = $profil->getId();
            $data['libelle'] = $profil->getLibelle();
            array_push($datas, $data);
        }
        return array("status" => true, "code" => 200, "data" => $datas);
    }

    public function deleteProfil($id)
    {
        $profil = $this->em->getRepository(Profil::class)->find($id);
        if(!$profil){
            return array("status" => false, "code", "message" => "Id profil invalide");
        }
        $this->em->remove($profil);
        $this->em->flush();
        return array("status" => true, "code" => 201, "message" => "Profil supprimé avec succès");
    }
}