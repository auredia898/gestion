<?php

namespace App\Repository;

use App\Entity\Hoursworked;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hoursworked>
 *
 * @method Hoursworked|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hoursworked|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hoursworked[]    findAll()
 * @method Hoursworked[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HoursworkedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hoursworked::class);
    }

//    /**
//     * @return Hoursworked[] Returns an array of Hoursworked objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Hoursworked
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
