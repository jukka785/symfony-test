<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MovieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function findAllAfterYear($year)
    {
        return $this->createQueryBuilder('m')
            ->where('m.year > :year')->setParameter('year', $year)
            ->orderBy('m.year', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
