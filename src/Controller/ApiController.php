<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController
{
    #[Route('/api/posts', 'api_get_posts', methods: ['GET'])]
    public function number(): JsonResponse
    {
        return new JsonResponse(
            [
                [
                    'name' => 'Vand teren + casa la rosu',
                    'price' => [
                        'currency' => 'EUR',
                        'amount' => 45000
                    ],
                    'location' => [
                        'short_string_location' => 'Comuna Moneasa',
                        'lat' => 46.50,
                        'long' => 23.01
                    ],
                    'offer_surface' => 1000,
                    'desc' => 'Vand casa la rosu si teren.
                    Casa cu o suprafata de 300m2 construita (parter+etaj+mansarda) si 50m2 terasa+balcoane.
                    Curte cu o suprafata de 1600 m2. Suprafata totala teren 1770 m2.
                    Casa este la o distanta de 50m de soseaua principala.
                    Casa se afla in comuna Moneasa, langa statiunea Moneasa din jud. Arad.
                    Pret 45.000 euro negociabil.',
                    'pictures' => [
                        'main' => '/public/images/aaaaa-1111/1.jpg',
                        2 => '/public/images/aaaaa-1111/2.jpg',
                        3 => '/public/images/aaaaa-1111/3.jpg',
                    ],
                    'source' => 'FB Group',
                    'author' => 'Jane Doe',
                    'contact' => [
                        'phone_number' => 1234567899,
                        'username' => '',
                    ],
                    'original_link' => 'https://www.facebook.com/groups/737166693909154/post-id-1',
                    'tags' => ['offer', 'terrain'],
                ],
                [
                    'name' => 'Vand teren 18770mp (1.87 Hectare ) in Muntele Baisorii jud CLUJ',
                    'price' => [
                        'currency' => 'EUR',
                        'amount' => 50000
                    ],
                    'location' => [
                        'short_string_location' => 'Muntele Baisorii ',
                        'lat' => 46.50,
                        'long' => 23.01
                    ],
                    'offer_surface' => 18000,
                    'desc' => 'Vand teren 18770mp (1.87 Hectare ) in Muntele Baisorii jud CLUJ . 
                        pe teren se afla o casa D+P racordata la curent cu numar de casa si o casuta mai mica tot cu numar de casa si aceasta fiind racordata la curent ! 
                        cateva anexe posibilitatea de racordare la apă de izvor prin cădere (apă din belșug) 12 euro / mp negociabil ! 
                        mai multe informatii la telefon: 0756305451',
                    'pictures' => [
                        'main' => '/public/images/aaaaa-1112/1.jpg',
                        2 => '/public/images/aaaaa-1112/2.jpg',
                        3 => '/public/images/aaaaa-1112/3.jpg',
                    ],
                    'source' => 'FB Group',
                    'author' => 'John Doe',
                    'contact' => [
                        'phone_number' => 1234567899,
                        'username' => '',
                    ],
                    'original_link' => 'https://www.facebook.com/groups/737166693909154/post-id-2',
                    'tags' => ['offer', 'terrain', 'house'],
                ],
            ]
        );
    }
}
