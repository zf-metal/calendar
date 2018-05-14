<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SpecificRangeRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class SpecificRangeRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\SpecificRange $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\SpecificRange $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

