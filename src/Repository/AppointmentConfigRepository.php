<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AppointmentConfigRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class AppointmentConfigRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\AppointmentConfig $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\AppointmentConfig $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

