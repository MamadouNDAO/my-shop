<?php

namespace App\Controller;

use App\Model\ProfilManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
}
