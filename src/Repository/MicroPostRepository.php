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

   
   public function paginationQuery()
   {
       return $this->createQueryBuilder('m')
           ->orderBy('m.id', 'ASC')
           ->getQuery()
       ;
   }

    public function findAllWithMinLikes(int $minLike):array
    {
        return $this->createQueryBuilder('m')
        ->leftJoin('m.likedBy', 'u')
        ->leftJoin('m.author', 'a') // Joindre l'auteur
        ->andWhere('a.isActive = :isActive') // Condition pour l'utilisateur actif
        ->setParameter('isActive', true) 
        ->groupBy('m.id')
        ->having('COUNT(u) >= 1')
        ->orderBy('COUNT(u)', 'DESC') // Utilisez COUNT(u) pour trier par le nombre de like
        ->setMaxResults($minLike)
        ->getQuery()
        ->getResult();
    }
    //equivalant de mysql:
//     SELECT p.*, COUNT(u.user_id) as likeCount
// FROM micro_post p
// LEFT JOIN micro_post_user u ON p.id = u.micro_post_id
// LEFT JOIN user a ON p.author_id = a.id
// WHERE a.is_active = 1
// GROUP BY p.id
// HAVING likeCount >= 1
// ORDER BY likeCount DESC;


    public function findPostsByFollows(User $user): array
    {
        return $this->createQueryBuilder('m')
            ->join('m.author', 'u') 
            ->join('u.follows', 'follower') 
            ->andWhere('u.isActive = :isActive')
            ->andwhere('follower.id = :userId')
            ->setParameter('isActive', true)
            ->setParameter('userId', $user->getId())
            ->orderBy('m.createdAt', 'DESC') 
            ->getQuery()
            ->getResult();
    }

//     SELECT m.* FROM micro_post m 
// JOIN user u ON m.author_id = u.id 
// JOIN followers f ON u.id = f.user_source 
// WHERE u.is_active = 1 
// AND f.user_target = 36 
// ORDER BY m.created_at ASC;

    
    
    public function findActiveUserPosts()
    {
        return $this->createQueryBuilder('mp')
            ->join('mp.author', 'u')
            ->andWhere('u.isActive = :isActive')
            ->setParameter('isActive', true)
            ->orderBy('mp.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    // eqivallat de requet mysql

//     SELECT mp.*
// FROM micro_post mp
// JOIN user u ON mp.author_id = u.id
// WHERE u.is_active = 1
// ORDER BY mp.created_at DESC;
}
