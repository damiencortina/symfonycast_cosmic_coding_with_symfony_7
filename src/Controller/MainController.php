<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\StarshipRepository;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(
        Request $request,
        StarshipRepository $starshipRepository,
    ): Response {
        $ships = $starshipRepository->findIncomplete();
        $ships->setMaxPerPage(5);
        $ships->setCurrentPage($request->query->get('page', 1));
        $myShip = $starshipRepository->findMyShip();

        return $this->render('main/homepage.html.twig', [
            'ships' => $ships,
            'myShip' => $myShip,
        ]);
    }
}
