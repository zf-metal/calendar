<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class CategoryRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\Category $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\Category $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

