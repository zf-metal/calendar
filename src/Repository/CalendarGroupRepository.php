<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CalendarGroupRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class CalendarGroupRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\CalendarGroup $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\CalendarGroup $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

