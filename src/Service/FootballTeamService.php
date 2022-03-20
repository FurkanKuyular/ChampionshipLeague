<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use App\Entity\FootballTeam;
use http\Exception\BadUrlException;
use Psr\Container\ContainerInterface;
use App\Repository\FootballTeamRepository;

class FootballTeamService extends AbstractService
{
    public function __construct(
        ContainerInterface $container,
        LoggerInterface $logger,
        protected FootballTeamRepository $footballTeamRepository,
    )
    {
        parent::__construct($container, $logger);
    }

    /**
     * @return array|null
     */
    public function getFootballTeams(): ?array
    {
        try {
            return $this->footballTeamRepository->getFootbalTeams();
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('[FootballTeamService][getFootballTeams] %s', $e));
        }

        return null;
    }

    /**
     * @return bool|null
     */
    public function resetLeague(): void
    {
        try {
            $this->footballTeamRepository->resetLeague();
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('[FootballTeamService][resetLeague] %s', $e));
        }
    }

    public function calculatePredictions()
    {
        try {
            $footballTeams = $this->getFootballTeams();
            $predictions = [];

            /** @var FootballTeam $footballTeam */
            foreach ($footballTeams as $footballTeam) {
                $result = 36 * $footballTeam['point'];

                dd($result / 100);
                //$predictions[$footballTeam['name']][] =  [];
            }
        } catch (\Throwable $e) {
            dd($e);
            $this->logger->error(sprintf('[FootballTeamService][calculatePredictions] %s', $e));
        }

        return null;
    }
}