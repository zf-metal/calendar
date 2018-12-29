<?php

namespace Test\DataFixture;

/**
 * Created by PhpStorm.
 * User: crist
 * Date: 1/6/2018
 * Time: 12:21
 */
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\ORM\EntityManager;
use ZfMetal\Calendar\Entity\Service;

class ServiceLoader extends AbstractFixture implements FixtureInterface
{

    const ENTITY = Service::class;


    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ArrayCollection
     */
    protected $services;

    /**
     * @return mixed
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @return ArrayCollection
     */
    public function getServices()
    {
        if (!$this->services) {
            $this->services = new ArrayCollection();
        }
        return $this->services;
    }


    protected function findByName($name)
    {
        return $this->getEm()->getRepository($this::ENTITY)->findOneByName($name);
    }


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $this->em = $manager;

        $this->createService(1, "General", "MANOLO CHAPS", "Casa Central");
        $this->createService(2, "Secondary", "MANOLO CHAPS", "Sur");
        $this->createService(3, "Trick", "MANOLO CHAPS", "Casa Central");
        $manager->flush();


    }


    public function createService($id, $name, $account,$branchOffice)
    {

        $service = $this->findByName($name);
        if (!$service) {
            $service = new Service();
            $service->setId($id);
            $service->setName($name);
            $service->setClient($this->getReference($account));
            $service->setBranchOffice($this->getReference($branchOffice));

        }

        $this->getEm()->persist($service);

        //Add reference for relations
        $this->addReference($name, $service);

        $this->getServices()->add($service);
    }

}