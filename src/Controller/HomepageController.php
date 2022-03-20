<?php

namespace App\Controller;

use App\Service\MatchService;
use Doctrine\ORM\AbstractQuery;
use App\Service\FootballTeamService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    #[Route('/homepage', name: 'homepage', methods: ['GET'])]
    public function homepage(FootballTeamService $footballTeamService, MatchService $matchService, Request $request)
    {
        $message = $request->query->get('message', null);

        $footballTeams = $footballTeamService->getFootballTeams();
        $matches = $matchService->getMatches(AbstractQuery::HYDRATE_ARRAY);

        $weeks = array_column($matches, 'week');
        $weeks = array_unique($weeks);
        sort($weeks);

        return $this->render('homepage/homepage.html.twig', [
            'footballTeams' => $footballTeams,
            'matches' => $matches,
            'weeks' => $weeks,
            'message' => $message,
        ]);
    }
}