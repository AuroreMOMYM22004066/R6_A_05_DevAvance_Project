<?php

namespace App\Controller;

use App\Repository\QcmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AllQcmController extends AbstractController
{
    #[Route('/qcm', name: 'app_all_qcm')]
    public function index(QcmRepository $qcmRepository): Response
    {

        // Récupérer tous les QCMs depuis la base de données
        $qcms = $qcmRepository->findAll();

        // Renvoyer la réponse avec les QCMs dans la vue
        return $this->render('all_qcm/index.html.twig', [
            'qcms' => $qcms,
        ]);
    }
}
