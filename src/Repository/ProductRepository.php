<?php

namespace App\Repository;

use App\Entity\Product;
use App\Filter\SearchFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    #[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])]
    public function findByTitle(string $query): array
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder->where('p.title LIKE :query');
        $queryBuilder->setParameter('query', '%'.$query.'%');

        return $queryBuilder->getQuery()->getResult();
    }
}
