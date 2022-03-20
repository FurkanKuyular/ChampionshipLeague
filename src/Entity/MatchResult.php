<?php

namespace App\Entity;

use App\Entity\Trait\StartDateTrait;
use App\Entity\Trait\EndedDateTrait;
use App\Repository\MatchResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table('matches')]
#[ORM\Entity(repositoryClass: MatchResultRepository::class)]
class MatchResult
{
    use StartDateTrait, EndedDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: FootballTeam::class)]
    private FootballTeam $homeFootballTeam;

    #[ORM\Column(type: 'integer')]
    private $homeFootballTeamScore;

    #[ORM\ManyToOne(targetEntity: FootballTeam::class)]
    private FootballTeam $awayFootballTeam;

    #[ORM\Column(type: 'integer')]
    private $awayFootballTeamScore;

    #[ORM\Column(type: 'integer')]
    private $week;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return FootballTeam
     */
    public function getHomeFootballTeam(): FootballTeam
    {
        return $this->homeFootballTeam;
    }

    /**
     * @param FootballTeam $homeFootballTeam
     *
     * @return MatchResult
     */
    public function setHomeFootballTeam(FootballTeam $homeFootballTeam): MatchResult
    {
        $this->homeFootballTeam = $homeFootballTeam;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHomeFootballTeamScore()
    {
        return $this->homeFootballTeamScore;
    }

    /**
     * @param mixed $homeFootballTeamScore
     *
     * @return MatchResult
     */
    public function setHomeFootballTeamScore($homeFootballTeamScore)
    {
        $this->homeFootballTeamScore = $homeFootballTeamScore;
        return $this;
    }

    /**
     * @return FootballTeam
     */
    public function getAwayFootballTeam(): FootballTeam
    {
        return $this->awayFootballTeam;
    }

    /**
     * @param FootballTeam $awayFootballTeam
     *
     * @return MatchResult
     */
    public function setAwayFootballTeam(FootballTeam $awayFootballTeam): MatchResult
    {
        $this->awayFootballTeam = $awayFootballTeam;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAwayFootballTeamScore()
    {
        return $this->awayFootballTeamScore;
    }

    /**
     * @param mixed $awayFootballTeamScore
     *
     * @return MatchResult
     */
    public function setAwayFootballTeamScore($awayFootballTeamScore)
    {
        $this->awayFootballTeamScore = $awayFootballTeamScore;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * @param mixed $week
     *
     * @return MatchResult
     */
    public function setWeek($week)
    {
        $this->week = $week;
        return $this;
    }
}
