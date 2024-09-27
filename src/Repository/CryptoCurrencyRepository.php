<?php

namespace App\Repository;

use App\Entity\CryptoCurrency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CryptoCurrency>
 */
class CryptoCurrencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CryptoCurrency::class);
    }

    public function findBySymbol($symbol) {
        return $this->createQueryBuilder('c')
            ->where('c.symbol = :symbol')
            ->setParameter('symbol', $symbol)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByMinPrice($minPrice) {
        return $this->createQueryBuilder('c')
            ->where('c.currentPrice > :minPrice')
            ->setParameter('minPrice',$minPrice)
            ->getQuery()
            ->getResult();
    }
}
