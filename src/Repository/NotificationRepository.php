<?php

namespace App\Repository;

use App\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notification>
 *
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

//    /**
//     * @return Notification[] Returns an array of Notification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

   public function findOneBySomeFields($expediteur,$destinataire,$entite,$type): ?Notification
   {
        return $this->createQueryBuilder('n')
            ->andWhere('n.expediteur = :expediteur')
            ->andWhere('n.destinataire = :destinataire')
            ->andWhere('n.data like %:entite')
            ->andWhere('n.type = :type')
            ->setParameter('expediteur', $expediteur)
            ->setParameter('destinataire', $destinataire)
            ->setParameter('type', $type)
            ->setParameter('entite', $entite)
            ->getQuery()
            ->getOneOrNullResult();
   }
}
