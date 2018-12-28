<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;
use ZfMetal\Calendar\Entity\Service;

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
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\Service $entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }


    public function search($id= null, $account= null, $branchOffice = null, $address= null)
    {
        $query = $this->getEntityManager()->createQueryBuilder('u')
            ->select('u')
            ->from(Service::class, 'u');

        if ($id) {
            $query->andWhere('u.id = :id')
                ->setParameter("id", $id);
        }

        if ($account) {

            $query->leftJoin('u.account', 'a')
                ->andWhere('a.name = :account')
                ->setParameter("account", $account);
        }


        return $query->getQuery()->getArrayResult();

    }

}

