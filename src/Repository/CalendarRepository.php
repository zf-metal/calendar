<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use phpDocumentor\Reflection\Types\Array_;
use ZfMetal\Calendar\Entity\Calendar;

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
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\Calendar $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
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


}

