<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    #[Route('/', 'home', methods: ['GET'])]
    public function number(): JsonResponse
    {
        return new JsonResponse(
            'Hola!'
        );
    }
}
