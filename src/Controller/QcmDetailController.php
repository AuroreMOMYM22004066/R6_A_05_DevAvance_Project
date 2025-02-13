<?php

namespace App\Controller;

use App\Repository\QcmRepository;
use App\Repository\AnswerRepository; // On importe le repository des réponses
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class QcmDetailController extends AbstractController
{
    #[Route('/qcm/{id}', name: 'app_qcm_show')]
    public function index(int $id, QcmRepository $qcmRepository, AnswerRepository $answerRepository, Request $request): Response
    {
        // Récupération du QCM par ID
        $qcm = $qcmRepository->find($id);

        if ($qcm == null) {
            throw $this->createNotFoundException('QCM non trouvé');
        }

        // Récupérer les questions du QCM (tu dois avoir une relation entre QCM et Question)
        $questions = $qcm->getQuestions();

        // Vérification de l'étape du quiz (quelle question on affiche)
        $questionIndex = $request->get('questionIndex', 0);  // Le premier index de question par défaut

        // Vérification de la réponse envoyée et du calcul du score
        $score = $request->get('score', 0);
        if ($request->isMethod('POST')) {
            $answer = $request->get('answer');
            $question = $questions[$questionIndex];

            // Récupérer toutes les réponses de la question actuelle depuis la base de données
            $answers = $question->getAnswers();

            // Vérification des bonnes réponses
            $correctAnswers = [];
            foreach ($answers as $ans) {
                if ($ans->isCorrect()) {
                    $correctAnswers[] = $ans;
                }
            }

            // Si la réponse envoyée est correcte (on vérifie contre les bonnes réponses)
            if (in_array($answer, array_map(fn($correctAnswer) => $correctAnswer->getId(), $correctAnswers))) {
                $score++;
            }

            // Passer à la question suivante
            $questionIndex++;

            // Si toutes les questions sont passées, afficher le score final
            if ($questionIndex >= count($questions)) {
                return $this->render('qcm_detail/result.html.twig', [
                    'score' => $score,
                    'total' => count($questions),
                    'qcm' => $qcm,
                ]);
            }
        }

        // Afficher la question suivante
        $question = $questions[$questionIndex];

        return $this->render('qcm_detail/index.html.twig', [
            'qcm' => $qcm,
            'question' => $question,
            'choices' => $question->getAnswers(),
            'questionIndex' => $questionIndex,
            'score' => $score,
        ]);
    }
}
