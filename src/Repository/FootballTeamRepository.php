<?php

namespace App\Repository;

use App\Entity\FootballTeam;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FootballTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method FootballTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method FootballTeam[]    findAll()
 * @method FootballTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FootballTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FootballTeam::class);
    }

    /**
     * @return array
     */
    public function getFootbalTeams(): array
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.point', 'DESC')
            ->orderBy('f.goalDifference', 'DESC')
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    /**
     * @return void
     */
    public function resetLeague(): void
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->update()
            ->set('f.point', 0)
            ->set('f.goalDifference', 0)
            ->set('f.drawn', 0)
            ->set('f.lost', 0)
            ->set('f.won', 0)
            ->getQuery();

        $queryBuilder->execute();
    }
}
