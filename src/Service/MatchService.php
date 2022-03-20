<?php

namespace App\Service;

use App\Entity\MatchResult;
use Psr\Log\LoggerInterface;
use App\Entity\FootballTeam;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MatchResultRepository;

class MatchService extends AbstractService
{
    /**
     * @param ContainerInterface     $container
     * @param LoggerInterface        $logger
     * @param MatchResultRepository  $matchResultRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ContainerInterface $container,
        LoggerInterface $logger,
        protected MatchResultRepository $matchResultRepository,
        protected EntityManagerInterface $entityManager,
    )
    {
        parent::__construct($container, $logger);
    }

    /**
     * @return array|null
     */
    public function checkDrawLots(): ?array
    {
        try {
            return $this->entityManager->getRepository(MatchResult::class)->findAll();
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('[MatchService][checkDrawLots] %s', $e));
        }

        return null;
    }

    /**
     * @param int|null $type
     *
     * @return array|null
     */
    public function getMatches(?int $type = null): ?array
    {
        try {
            return $this->matchResultRepository->getMatches($type);
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('[MatchService][getMatches] %s', $e));
        }

        return null;
    }

    /**
     * @param FootballTeamService $footballTeamService
     *
     * @return bool
     */
    public function drawlots(FootballTeamService $footballTeamService): bool
    {
        try {
            $footballTeams = $footballTeamService->getFootballTeams();

            $matches = $this->matchTeams($footballTeams);

            foreach (($matches ?? []) as $halfs) {
                foreach (($halfs ?? []) as $currentHalfMatch) {
                    $currentHalfMatch = (new MatchResult())
                    ->setHomeFootballTeam($this->entityManager->getReference(FootballTeam::class, (int) $currentHalfMatch['homeFootballTeamId']))
                    ->setAwayFootballTeam($this->entityManager->getReference(FootballTeam::class, (int) $currentHalfMatch['awayFootballTeamId']))
                    ->setHomeFootballTeamScore(0)
                    ->setAwayFootballTeamScore(0)
                    ->setWeek($currentHalfMatch['week'])
                    ->setStartDate($currentHalfMatch['startDate'])
                    ->setEndedDate(null);

                    $this->entityManager->persist($currentHalfMatch);
                    $this->entityManager->flush();
                }
            }

            return true;
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('[MatchService][drawlots] %e', $e));
        }

        return false;
    }

    /**
     * @param FootballTeamService $footballTeamService
     *
     * @return bool
     */
    public function playMatches(FootballTeamService $footballTeamService): bool
    {
        try {
            $matches = $this->getMatches();

            /** @var MatchResult $match */
            foreach (($matches ?? []) as $match) {
                $endedDate = $match->getStartDate()->modify('+105 minutes');

                $match->setHomeFootballTeamScore(random_int(0, 5));
                $match->setAwayFootballTeamScore(random_int(0, 5));
                $match->setEndedDate($endedDate);

                $this->entityManager->persist($match);

                $homeFootballTeam = $match->getHomeFootballTeam();
                $awayFootballTeam = $match->getAwayFootballTeam();

                $homeFootballTeam->setGoalDifference($homeFootballTeam->getGoalDifference() + $match->getHomeFootballTeamScore());
                $awayFootballTeam->setGoalDifference($awayFootballTeam->getGoalDifference() + $match->getAwayFootballTeamScore());

                if ($match->getHomeFootballTeamScore() > $match->getAwayFootballTeamScore()) {
                    $homeFootballTeam->setWon($homeFootballTeam->getWon() + 1);
                    $homeFootballTeam->setPoint($homeFootballTeam->getWon() + 3);

                    $this->entityManager->persist($homeFootballTeam);
                    $this->entityManager->flush();

                    $awayFootballTeam->setLost($awayFootballTeam->getLost() + 1);

                    $this->entityManager->persist($awayFootballTeam);
                    $this->entityManager->flush();
                }

                if ($match->getAwayFootballTeamScore() > $match->getHomeFootballTeamScore()) {
                    $awayFootballTeam->setWon($awayFootballTeam->getWon() + 1);
                    $awayFootballTeam->setPoint($awayFootballTeam->getPoint() + 3);

                    $this->entityManager->persist($awayFootballTeam);
                    $this->entityManager->flush();

                    $homeFootballTeam->setLost($homeFootballTeam->getLost() + 1);

                    $this->entityManager->persist($homeFootballTeam);
                    $this->entityManager->flush();
                }

                if ($match->getAwayFootballTeamScore() === $match->getHomeFootballTeamScore()) {
                    $homeFootballTeam->setPoint($homeFootballTeam->getPoint() + 1);
                    $homeFootballTeam->setDrawn($homeFootballTeam->getDrawn() + 1);

                    $awayFootballTeam->setPoint($awayFootballTeam->getPoint() + 1);
                    $awayFootballTeam->setDrawn($awayFootballTeam->getDrawn() + 1);
                }
            }


            return true;
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('[MatchService][playMatches] %s', $e));
        }

        return false;
    }

    /**
     * @param int $week
     *
     * @return \DateTime
     */
    private function getWeekDate(int $week): \DateTimeInterface
    {
        $date = new \DateTime();
        $date->modify(sprintf('+%s week', $week));

        return $date;
    }

    /**
     * @param array $footballTeams
     *
     * @return array
     *
     * @throws \JsonException
     */
    private function matchTeams(array $footballTeams): array
    {
        try {
            $allTeamsCount = count($footballTeams);
            $matchTeamsCount = $allTeamsCount / 2;

            $firstHalf = range(1, 6);
            $secondHalf = range(4, 12);

            $matches = [];

            // First half matches
            for ($i = 0; $i < $matchTeamsCount; $i++) {
                $matches['firstHalf'][] = [
                    'homeFootballTeamId' => $footballTeams[$i]['id'],
                    'awayFootballTeamId' => $footballTeams[$allTeamsCount-($i+1)]['id'],
                    'week' => $firstHalf[0],
                    'startDate' => $this->getWeekDate($firstHalf[0]),
                ];

                $matches['secondHalf'][] = [
                    'homeFootballTeamId' => $footballTeams[$allTeamsCount-($i+1)]['id'],
                    'awayFootballTeamId' => $footballTeams[$i]['id'],
                    'week' => $secondHalf[0],
                    'startDate' => $this->getWeekDate($secondHalf[0]),
                ];
            }

            // Next week matches
            for ($i = $matchTeamsCount; $i < $allTeamsCount; ++$i) {
                $nextWeekTeam = $footballTeams[$i];

                for ($j = 0; $j < $matchTeamsCount - 1; ++$j) {
                    $matches['firstHalf'][] = [
                        'homeFootballTeamId' => $nextWeekTeam['id'],
                        'awayFootballTeamId' => $footballTeams[$i - $matchTeamsCount]['id'],
                        'week' => $firstHalf[$j + 1],
                        'startDate' => $this->getWeekDate($firstHalf[$j + 1]),
                    ];

                    $matches['secondHalf'][] = [
                        'homeFootballTeamId' => $footballTeams[$i - $matchTeamsCount]['id'],
                        'awayFootballTeamId' => $nextWeekTeam['id'],
                        'week' => $secondHalf[$j + 1],
                        'startDate' => $this->getWeekDate($secondHalf[$j + 1]),
                    ];
                }
            }

            for ($i = 0; $i < $allTeamsCount; $i++) {
                foreach ($footballTeams as $key => $footballTeam) {
                    if (($key - 1) === $i) {
                        $matches['firstHalf'][] = [
                            'homeFootballTeamId' => $footballTeams[$i]['id'],
                            'awayFootballTeamId' => $footballTeam['id'],
                            'week' => $firstHalf[$matchTeamsCount],
                            'startDate' => $this->getWeekDate($firstHalf[$matchTeamsCount]),
                        ];

                        $matches['secondHalf'][] = [
                            'homeFootballTeamId' => $footballTeam['id'],
                            'awayFootballTeamId' => $footballTeams[$i]['id'],
                            'week' => $secondHalf[$matchTeamsCount],
                            'startDate' => $this->getWeekDate($secondHalf[$matchTeamsCount]),
                        ];

                        array_shift($footballTeams);
                    }
                }
            }

            return $matches;
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('[MatchService][matchTeams] %s', $e), [
                'footballTeams' => json_decode((string)$footballTeams, false, 512, JSON_THROW_ON_ERROR),
            ]);
        }

        return [];
    }
}