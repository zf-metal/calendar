<?php
/**
 * Created by PhpStorm.
 * User: crist
 * Date: 11/12/2018
 * Time: 00:14
 */

namespace Test\DataFixture;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\ORM\EntityManager;
use ZfMetal\Calendar\Entity\AppointmentState;

class AppointmentStateLoader  extends AbstractFixture implements FixtureInterface
{

    const ENTITY = \ZfMetal\Calendar\Entity\AppointmentState::class;



    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ArrayCollection
     */
    protected $appointmentStates;

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
    public function getAppointmentStates()
    {
        if (!$this->appointmentStates) {
            $this->appointmentStates = new ArrayCollection();
        }
        return $this->appointmentStates;
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

        $this->createAppointmentState(1, "");

        $manager->flush();


    }


    /**
     * @param $id
     * @param $name
     * @param $tradename
     */
    public function createAppointmentState($id, $name)
    {

        $AppointmentState = $this->findByName($name);
        if (!$AppointmentState) {
            $AppointmentState = new AppointmentState();
            $AppointmentState->setId($id);
            $AppointmentState->setName($name);
        }


        $this->getEm()->persist($AppointmentState);

        //Add reference for relations
        $this->addReference($name, $AppointmentState);

        $this->getAppointmentState()->add($AppointmentState);
    }

}