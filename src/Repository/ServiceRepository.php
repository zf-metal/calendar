<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ServiceRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ServiceRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\Service $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\Service $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

