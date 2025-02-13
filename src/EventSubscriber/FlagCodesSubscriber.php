<?php

// src/EventSubscriber/FlagCodesSubscriber.php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FlagCodesSubscriber implements EventSubscriberInterface
{
    private HttpClientInterface $client;
    private Environment $twig;
    private RequestStack $requestStack;

    public function __construct(HttpClientInterface $client, Environment $twig, RequestStack $requestStack)
    {
        $this->client = $client;
        $this->twig = $twig;
        $this->requestStack = $requestStack;
    }

    public function onKernelController(ControllerEvent $event)
    {
        // Appel à l'API pour récupérer les drapeaux
        $api_flag_url = $_ENV['API_FLAG_URL'];

        try {
            $response = $this->client->request('GET', ''.$api_flag_url.'/api/flag_codes'); // URL de l'API
            $flagCodes = $response->toArray();

            // Extraire le tableau 'member' des données de l'API
            $flagCodes = $flagCodes['member'] ?? [];
        } catch (\Exception $e) {
            $flagCodes = []; // En cas d'erreur, on met une liste vide
        }

        // Ajouter les données à Twig pour qu'elles soient disponibles globalement
        $this->twig->addGlobal('flagCodes', $flagCodes);

        //dump($flagCodes);  // Pour vérifier ce qui est bien passé
    }


    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
