<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @return array<int, Game>
     */
    public function findByTopScores(): array
    {
        return $this->createQueryBuilder('g')
            ->select(['min(g.score) as score', 'p.name as playerName'])
            ->join('g.player', 'p')
            ->orderBy('score', 'ASC')
            ->groupBy('p.name')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByPlayerName(string $playerName): array
    {
        return $this->createQueryBuilder('g')
            ->join('g.player', 'p')
            ->where('p.name = :playerName')
            ->setParameter('playerName', $playerName)
            ->getQuery()
            ->getResult()
        ;
    }

    public function save(Game $game): void
    {
        $this->getEntityManager()->persist($game);
        $this->getEntityManager()->flush();
    }
}
