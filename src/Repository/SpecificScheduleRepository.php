<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SpecificScheduleRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class SpecificScheduleRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\SpecificSchedule $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\SpecificSchedule $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

