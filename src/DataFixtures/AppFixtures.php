<?php

namespace App\DataFixtures;

use App\Entity\FootballTeam;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $footballTeams = [
            'Chelsea',
            'Arsenal',
            'Manchester City',
            'Liverpool',
        ];

        foreach ($footballTeams as $footballTeam) {
            $footballTeamEntity = new FootballTeam();
            $footballTeamEntity->setName($footballTeam);
            $footballTeamEntity->setWon(0);
            $footballTeamEntity->setLost(0);
            $footballTeamEntity->setDrawn(0);
            $footballTeamEntity->setGoalDifference(0);
            $footballTeamEntity->setPoint(0);

            $manager->persist($footballTeamEntity);
        }

        $manager->flush();
    }
}
