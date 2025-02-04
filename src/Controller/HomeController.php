<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Si l'utilisateur est connecté, on affiche "Bonjour [Nom]"
        if ($user) {
            return $this->render('home/index.html.twig', [
                'user' => $user,
                'is_logged_in' => true,
            ]);
        }

        // Sinon, on affiche des liens pour se connecter et s'inscrire
        return $this->render('home/index.html.twig', [
            'is_logged_in' => false,
        ]);
    }
}
