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

    public function search($id = null, $client = null, $branchOffice = null, $location = null)
    {
        $query = $this->getEntityManager()->createQueryBuilder('u')
            ->select('u.id, u.name,c.name as client, bo.name as branchOffice, bo.location as location ')
            ->from(Service::class, 'u')
            ->leftJoin('u.client', 'c')
            ->leftJoin('u.branchOffice', 'bo');

        if ($id) {
            $query->andWhere('u.id = :id')
                ->setParameter("id", $id);
        }

        if ($client) {

            $query->andWhere('c.name like :client')
                ->setParameter("client", '%'.$client.'%');
        }

        if ($branchOffice) {

            $query->andWhere('bo.name like :branchOffice')
                ->setParameter("branchOffice",  '%'.$branchOffice.'%');
        }


        if ($location) {

            $query->andWhere('bo.location like :location')
                ->setParameter("location",  '%'.$location.'%');
        }



        return $query->getQuery()->getArrayResult();
    }


}

