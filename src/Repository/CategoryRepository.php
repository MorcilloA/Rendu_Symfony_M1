<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function getSubCategoriesByMainCategorySlug(string $slugCategory):Query
    {
        $query = $this
            ->createQueryBuilder('category')
            ->join('category.parent', 'parent')
            // ->select('category.name, category.slug')
            // ->andWhere('category.name LIKE :name')
            ->andWhere('parent.slug = :slug')
            ->setParameters([
                // 'name' => 'b%'
                'slug' => $slugCategory
            ])
            // ->setMaxResults(2)
            ->getQuery()
        ;

        return $query;
    }

    public function getSubCategories(): QueryBuilder
    {
        $query = $this
            ->createQueryBuilder('category')
            ->andWhere('category.parent is not null')
        ;

        return $query;
    }

    public function getCategoriesByNamePart(string $searching): Query
    {
        $query = $this
            ->createQueryBuilder('category')
            ->andWhere("category.name LIKE :search")
            ->setParameter('search', "$searching%")
            ->getQuery()
        ;

        return $query;
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
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
    public function findOneBySomeField($value): ?Category
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
