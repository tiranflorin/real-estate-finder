<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    #[Route('/', 'home', methods: ['GET'])]
    public function number(): Response
    {
        return new Response(
            '<html><body>Real Estate Finder</body></html>'
        );
    }
}
