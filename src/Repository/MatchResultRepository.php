<?php

namespace App\Repository;

use App\Entity\MatchResult;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method MatchResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchResult[]    findAll()
 * @method MatchResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchResult::class);
    }

    /**
     * @param int|null $type
     *
     * @return array
     */
    public function getMatches(?int $type = null): array
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->select('m', 'mf', 'ma')
            ->where('m.startDate IS NOT NULL');

        $queryBuilder->innerJoin('m.homeFootballTeam', 'mf');
        $queryBuilder->innerJoin('m.awayFootballTeam', 'ma');
        $queryBuilder
            ->orderBy('m.week', 'ASC')
            ->orderBy('m.id', 'ASC');

        $queryBuilder = $queryBuilder->getQuery();

        if (!empty($type)) {
         return $queryBuilder->getResult($type);
        }

        return $queryBuilder->getResult();
    }
}
