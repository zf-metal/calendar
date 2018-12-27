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
use ZfMetal\Calendar\Entity\BranchOffice;

class BranchOfficeLoader extends AbstractFixture implements FixtureInterface
{

    const ENTITY = BranchOffice::class;


    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ArrayCollection
     */
    protected $branchOffices;

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
    public function getBranchOffices()
    {
        if (!$this->branchOffices) {
            $this->branchOffices = new ArrayCollection();
        }
        return $this->branchOffices;
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

        $this->createBranchOffice(1, "Casa Central");
        $manager->flush();


    }


    public function createBranchOffice($id, $name)
    {

        $branchOffice = $this->findByName($name);
        if (!$branchOffice) {
            $branchOffice = new BranchOffice();
            $branchOffice->setId($id);
            $branchOffice->setName($name);
            $branchOffice->setAccount($this->getReference("MANOLO CHAPS"));
            $branchOffice->setAddress("Directorio");
        }


        $this->getEm()->persist($branchOffice);

        //Add reference for relations
        $this->addReference($name, $branchOffice);

        $this->getBranchOffices()->add($branchOffice);
    }

}