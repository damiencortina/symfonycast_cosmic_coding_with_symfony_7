<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\StarshipRepository;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(
        StarshipRepository $starshipRepository,
    ): Response {
        $ships = $starshipRepository->findIncomplete();
        $myShip = $starshipRepository->findMyShip();

        return $this->render('main/homepage.html.twig', [
            'ships' => $ships,
            'myShip' => $myShip,
        ]);
    }
}
