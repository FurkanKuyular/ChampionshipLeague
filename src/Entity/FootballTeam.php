<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FootballTeamRepository;

#[ORM\Table(name: 'football_teams')]
#[ORM\Entity(repositoryClass: FootballTeamRepository::class)]
class FootballTeam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 100)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $won;

    #[ORM\Column(type: 'integer')]
    private int $drawn;

    #[ORM\Column(type: 'integer')]
    private int $lost;

    #[ORM\Column(type: 'integer')]
    private int $goalDifference;

    #[ORM\Column(type: 'integer')]
    private int $point;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return FootballTeam
     */
    public function setName(string $name): FootballTeam
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getWon(): int
    {
        return $this->won;
    }

    /**
     * @param int $won
     *
     * @return FootballTeam
     */
    public function setWon(int $won): FootballTeam
    {
        $this->won = $won;
        return $this;
    }

    /**
     * @return int
     */
    public function getDrawn(): int
    {
        return $this->drawn;
    }

    /**
     * @param int $drawn
     *
     * @return FootballTeam
     */
    public function setDrawn(int $drawn): FootballTeam
    {
        $this->drawn = $drawn;
        return $this;
    }

    /**
     * @return int
     */
    public function getLost(): int
    {
        return $this->lost;
    }

    /**
     * @param int $lost
     *
     * @return FootballTeam
     */
    public function setLost(int $lost): FootballTeam
    {
        $this->lost = $lost;
        return $this;
    }

    /**
     * @return int
     */
    public function getGoalDifference(): int
    {
        return $this->goalDifference;
    }

    /**
     * @param int $goalDifference
     *
     * @return FootballTeam
     */
    public function setGoalDifference(int $goalDifference): FootballTeam
    {
        $this->goalDifference = $goalDifference;
        return $this;
    }

    /**
     * @return int
     */
    public function getPoint(): int
    {
        return $this->point;
    }

    /**
     * @param int $point
     *
     * @return FootballTeam
     */
    public function setPoint(int $point): FootballTeam
    {
        $this->point = $point;
        return $this;
    }
}
