<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use phpDocumentor\Reflection\Types\Array_;
use ZfMetal\Calendar\Entity\Calendar;
use ZfMetal\Restful\Filter\Builder;
use ZfMetal\Restful\Filter\DoctrineQueryBuilderFilter;

/**
 * CalendarRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class CalendarRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\Calendar $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\Calendar $entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @return array
     */
    public function fullList()
    {
        $data = $this->getEntityManager()->createQueryBuilder('u')
            ->select('u')
            ->from(Calendar::class, 'u')
            ->join('u.schedules', 's')
            ->getQuery()
            ->getResult();

        return $data;
    }

    public function queryFilter($query)
    {
        $qb = $this->getEntityManager()->createQueryBuilder('u')->select('u')
            ->from(Calendar::class, 'u');

        $builder = new Builder($query,Builder::TYPE_SIMPLE);
        $builder->build();

        $DoctrineQueryBuilderFilter = new DoctrineQueryBuilderFilter($qb, $builder->getFilters());
        $qb = $DoctrineQueryBuilderFilter->applyFilters();


        return $qb->getQuery()->getResult();
    }


}

