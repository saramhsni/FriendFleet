<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\MicroPost;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<MicroPost>
 *
 * @method MicroPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method MicroPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method MicroPost[]    findAll()
 * @method MicroPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MicroPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MicroPost::class);
    }

//    /**
//     * @return MicroPost[] Returns an array of MicroPost objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MicroPost
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


    public function findAllWithMinLikes(int $minLike):array
    {
        return $this->createQueryBuilder('m')
        ->leftJoin('m.likedBy', 'u') // Assurez-vous que la propriété 'likedBy' est correcte dans votre entité MicroPost
        ->groupBy('m.id')
        ->having('COUNT(u) >= 1')
        ->orderBy('COUNT(u)', 'DESC') // Utilisez COUNT(u) pour trier par le nombre de 'j'aime'
        ->setMaxResults($minLike)
        ->getQuery()
        ->getResult();
    }

    public function findPostsByFollows(User $user): array
    {
        return $this->createQueryBuilder('m')
            ->join('m.author', 'u') // Assurez-vous que la relation entre MicroPost et User s'appelle 'author'
            ->join('u.follows', 'follower') // Assurez-vous que la relation entre User et User s'appelle 'follows'
            ->where('follower.id = :userId')
            ->setParameter('userId', $user->getId())
            ->orderBy('m.createdAt', 'DESC') // Tri par date de création, ajustez selon vos besoins
            ->getQuery()
            ->getResult();
    }
}
