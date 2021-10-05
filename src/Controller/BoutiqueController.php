<?php

namespace App\Controller;

use App\Model\BoutiqueManager;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BoutiqueController extends AbstractController
{
    protected $boutiqueManager;
    public function __construct(BoutiqueManager $boutiqueManager)
    {
        $this->boutiqueManager = $boutiqueManager;
    }

    /**
     * @Rest\Post("/api/ajoutBoutique")
     */
    public function ajoutBoutique(Request $request)
    {
        $data = $request->request->all();
        return new JsonResponse($this->boutiqueManager->createBoutique($data));
    }

    /**
     * @Rest\Post("/api/linkerBoutique/{id}")
     */
    public function linkBoutique($id, Request $request)
    {
        $data = $request->request->all();
        return new JsonResponse($this->boutiqueManager->linkerBoutique($id, $data));
    }

    /**
     * @Rest\Get("/api/listBoutiques")
     */
    public function listBoutique(Request $request)
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 10);
        $isArchived = $request->query->get('isArchived', null);
        if($isArchived == 'true'){
            $isArchived = true;
        }else if($isArchived == 'false'){
            $isArchived = false;
        }else{
            $isArchived = null;
        }
        return new JsonResponse($this->boutiqueManager->listBoutique($page, $limit, $isArchived));
    }

    /**
     * @Rest\Post("/api/updateBoutique/{id}")
     */
    public function updateBoutique($id, Request $request)
    {
        $data = $request->request->all();
        return new JsonResponse($this->boutiqueManager->updateBoutique($id, $data));
    }
}