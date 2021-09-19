<?php

namespace App\Controller;

use App\Model\ProfilManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ProfilController extends AbstractController
{
    protected $profilManager;

    public function __construct(ProfilManager $profilManager)
    {
        $this->profilManager = $profilManager;
    }
    
    
    /**
     * @Rest\Post("/api/ajoutProfil")
     */
    public function addProfil(Request $request)
    {
        $data = $request->request->all();
        
        $reponse = $this->profilManager->ajoutProfil($data);
        
        return new JsonResponse($reponse);
    }

    /**
     * @Rest\Post("/api/updateProfil/{id}")
     */
    public function updateProfil(Request $request, $id)
    {
        $data = $request->request->all();
        $reponse = $this->profilManager->updateProfil($data, $id);
        return new JsonResponse($reponse);
    }

    /**
     * @Rest\Get("/api/listeProfil")
     */
    public function listeProfil()
    {
        $reponse = $this->profilManager->listProfil();
        return new JsonResponse($reponse);
    }

    /**
     * @Rest\Delete("/api/deleteProfil/{id}")
     */
    public function deleteProfil($id)
    {
        $reponse = $this->profilManager->deleteProfil($id);
        return new JsonResponse($reponse);
    }
}
