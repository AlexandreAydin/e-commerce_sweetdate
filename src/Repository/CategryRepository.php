<?php

namespace App\Repository;

use App\Entity\Categry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categry|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categry|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categry[]    findAll()
 * @method Categry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategryRepository extends ServiceEntityRepository
{

    


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categry::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Categry $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Categry $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Categry[] Returns an array of Categry objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Categry
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
