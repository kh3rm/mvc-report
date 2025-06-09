<?php

namespace App\Repository;

use App\Entity\HighscoreEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HighscoreEntry>
 *
 */
class HighscoreEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HighscoreEntry::class);
    }

    public function findAllEntriesScoreDesc()
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->orderBy('e.score', 'DESC')
            ->getQuery()
            ->getResult();
    }

/**
 * Clear all the highscore entries from the database.
 */
public function resetHs(): void
{
    $entityManager = $this->getEntityManager();

    $entityManager->createQuery('DELETE FROM ' . HighscoreEntry::class)->execute();
}
}