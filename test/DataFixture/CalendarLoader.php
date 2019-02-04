<?php

namespace Test\DataFixture;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\ORM\EntityManager;
use ZfMetal\Calendar\Entity\Calendar;
use ZfMetal\Calendar\Entity\PredefinedEvents;

class CalendarLoader extends AbstractFixture implements FixtureInterface
{

    const ENTITY = Calendar::class;


    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ArrayCollection
     */
    protected $calendars;

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
    public function getCalendars()
    {
        if (!$this->calendars) {
            $this->calendars = new ArrayCollection();
        }
        return $this->calendars;
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

        $this->createCalendar(1, "CalendarTest", 'schedule1');
        $manager->flush();


    }


    public function createCalendar($id, $name,$schedule)
    {

        $calendar = $this->findByName($name);
        if (!$calendar) {
            $calendar = new Calendar();
            $calendar->setId($id);
            $calendar->setName($name);

            //Predefined Events
            $predefinedEvents = new PredefinedEvents();
            $predefinedEvents->setDuration(60);
            $predefinedEvents->setBreak(0);
            $predefinedEvents->setMaxDaysForShifs(7);
            $calendar->setPredefinedEvents($predefinedEvents);

         //   $calendar->addSchedule($this->getReference($schedule));

        }

        $this->getEm()->persist($calendar);

        //Add reference for relations
        $this->addReference($name, $calendar);

        $this->getCalendars()->add($calendar);
    }

}