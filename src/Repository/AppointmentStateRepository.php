<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AppointmentStateRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class AppointmentStateRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\AppointmentState $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\AppointmentState $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

