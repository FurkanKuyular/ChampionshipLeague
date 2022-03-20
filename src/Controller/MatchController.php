<?php

namespace App\Controller;

use App\Service\MatchService;
use App\Service\FootballTeamService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MatchController extends AbstractController
{
    /**
     * @param FootballTeamService $footballTeamService
     * @param MatchService        $matchService
     *
     * @return RedirectResponse
     */
    #[Route('/draw-lot', name: 'draw_lots', methods: ['GET'])]
    public function drawLots(FootballTeamService $footballTeamService, MatchService $matchService): RedirectResponse
    {
        $checkHasDrawLots = $matchService->checkDrawLots();

        if (!empty($checkHasDrawLots)) {
            if (null === $checkHasDrawLots) {
                return $this->redirectToRoute('homepage', ['message' => 'A technical error has occurred']);
            } else {
                return $this->redirectToRoute('homepage', ['message' => 'The draw has already been drawn']);
            }
        }

        $drawLots = $matchService->drawlots($footballTeamService);

        if (!$drawLots) {
            return $this->redirectToRoute('homepage', ['message' => 'A technical error has occurred']);
        }

        return $this->redirectToRoute('homepage', []);
    }

    /**
     * @param FootballTeamService $footballTeamService
     * @param MatchService        $matchService
     *
     * @return RedirectResponse
     */
    #[Route('/play-match', name: 'play_match', methods: ['GET'])]
    public function playMatches(FootballTeamService $footballTeamService, MatchService $matchService): RedirectResponse
    {
        $footballTeamService->resetLeague();

        $matches = $matchService->playMatches($footballTeamService);

        if (!$matches) {
            return $this->redirectToRoute('homepage', ['message' => 'A technical error has occurred']);
        }

        return $this->redirectToRoute('homepage', []);
    }
}