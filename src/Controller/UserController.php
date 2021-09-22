<?php

namespace App\Controller;

use App\Model\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{
    protected $userManager;
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }
    
    /**
     * @Rest\Post("/api/ajoutUser")
     */
    public function addUser(Request $request)
    {
        $data = $request->request->all();
        return new JsonResponse($this->userManager->ajoutUser($data));
    }

    /**
     * @Rest\Post("/api/updateUser/{id}")
     */
    public function updateUser(Request $request, $id)
    {
        $data = $request->request->all();
        return new JsonResponse(($this->userManager->modifierUser($id, $data)));

    }
}