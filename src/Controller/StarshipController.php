<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Starship;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

class StarshipController extends AbstractController
{
    #[Route('/starships/{slug}', name: 'app_starship_show')]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])]
        Starship $starship
    ): Response {
        return $this->render('starship/show.html.twig', [
            'starship' => $starship,
        ]);
    }
}
