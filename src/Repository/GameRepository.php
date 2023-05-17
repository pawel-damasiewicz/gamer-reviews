<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function save(Game $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Game $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByNameLike(?string $value): array
    {
        $lowercaseQuery = mb_strtolower($query);

        $queryBuilder = $this->createQueryBuilder('g');

        $queryBuilder->orWhere(sprintf('LOWER(%s.%s) LIKE :query_for_text', 'g', 'name'))
            ->setParameter('query_for_text', '%' . $lowercaseQuery . '%');
        $queryBuilder->orWhere(sprintf('LOWER(%s.%s) IN (:query_as_words)', 'g', 'name'))
            ->setParameter('query_as_words', explode(' ', $lowercaseQuery));
        return $queryBuilder
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
