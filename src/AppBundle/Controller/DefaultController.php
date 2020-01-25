<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return new JsonResponse('Welcome to Document Validation Process');
    }
}
