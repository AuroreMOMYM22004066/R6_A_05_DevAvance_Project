<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, SessionInterface $session, TranslatorInterface $translator)
    {

        // Récupérer la langue du paramètre GET et la stocker en session
        $locale = $request->query->get('language', $session->get('_locale', 'en'));
        $session->set('_locale', $locale);
        $request->setLocale($locale);

        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        if ($user) {
            return $this->render('home/index.html.twig', [
                'user' => $user,
                'is_logged_in' => true,
            ]);
        }

        return $this->render('home/index.html.twig', [
            'is_logged_in' => false,
            'translatedMessage' => $translator->trans('welcome_message')
        ]);
    }
}
