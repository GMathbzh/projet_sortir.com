<?php

namespace App\Repository;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    /**
     * @return Sortie[]
     */
    public function findSortieFiltered(String $nom = null,User $user, string $debut = null, string $fin=  null, Site $lieu = null, bool $passee = false, bool $nonInscrit = false, bool $inscrit = false, bool $organisateur = false)
    {


        $query = $this->createQueryBuilder("s");
        if ($nom) {$query->andWhere("s.nom LIKE :nom")->setParameter("nom", "%$nom%");}
        if ($lieu) { $query->andWhere("s.site = :lieu")->setParameter("lieu", $lieu); }
        if ($debut) { $query->andWhere("s.dateheuredebut >= :debut")->setParameter("debut", $debut); }
        if ($fin) { $query->andWhere("s.dateheuredebut <= :fin")->setParameter("fin", $fin); }
        if ($organisateur) { $query->andWhere("s.organisateur = :organisateur")->setParameter("organisateur", $user->getId()); }
        if ($inscrit) { $query->andWhere(":isInscrit MEMBER OF s.users")->setParameter("isInscrit", $user->getId()); }
        if ($nonInscrit) { $query->andWhere(":nonInscrit NOT MEMBER OF s.users")->setParameter("nonInscrit", $user->getId()); }
        if ($passee) { $query->andWhere("s.dateheuredebut < :now")->setParameter("now", new \DateTime()) ;}


        $query = $query->getQuery();
        return $query->execute();
    }

    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
