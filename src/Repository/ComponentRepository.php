<?php declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Component;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Components|null find($id, $lockMode = null, $lockVersion = null)
 * @method Components|null findOneBy(array $criteria, array $orderBy = null)
 * @method Components[]    findAll()
 * @method Components[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComponentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Component::class);
    }
}
