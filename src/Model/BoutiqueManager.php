<?php

namespace App\Model;

use App\Entity\User;
use App\Entity\Boutique;
use Doctrine\ORM\EntityManagerInterface;

class BoutiqueManager
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createBoutique($data)
    {
        if(!isset($data['nom']) || $data['nom'] == ''){
            return array("status" => false, "code" => 500, "message" => "Le nom de boutique est obligatoire");
        }

        $boutique = new Boutique();
        $boutique->setNom($data['nom']);
        $this->em->persist($boutique);
        $this->em->flush();
        return array("status" => true, "code" => 201, "message" => "Votre boutique a été créée avec succès");
    }

    public function linkerBoutique($id, $data)
    {
        $boutique = $this->em->getRepository(Boutique::class)->find($id);
        if(!$boutique){
            return array("status" => false, "code" => 500, "message" => "Id boutique invalide");
        }
        foreach($data['users'] as $el){
            $user = $this->em->getRepository(User::class)->find($el['id']);
            if(!$user){
                return array("status" => false, "code" => 500, "message" => "Id utilisateur invalide");
            }
            $user->setBoutique($boutique);
            $this->em->flush();
        }

        return array("status" => true, "code" => 201, "message" => "Utilisateurs ajoutés à la boutique avec succès");
    }

    public function listBoutique($page, $limit, $isArchived)
    {
        $boutiques = $this->em->getRepository(Boutique::class)->findBoutique($page, $limit, $isArchived);

        if(empty($boutiques))
        {
            return array("status" =>true, "code" =>202, "message" => "contenu vide");

        }
        $total = sizeof($this->em->getRepository(Boutique::class)->findBoutique(null, null, $isArchived));
        return array("status" =>true, "code" =>200, "total" => $total, "data" =>$boutiques);
    }

    public function updateBoutique($id, $data)
    {
        $boutique = $this->em->getRepository(Boutique::class)->find($id);
        if(!$boutique){
            return array("status" => false, "code" => 500, "message" => "Id boutique invalide");
        }
        if(!isset($data['nom']) || $data['nom'] == ''){
            return array("status" => false, "code" => 500, "message" => "Nom de la boutique est obligatoire");
        }

        $boutique->setNom($data['nom']);
        $this->em->flush();
        return array("status" => true, "code" => 201, "message" => "Boutique modifiée avec succès");
    }

}