<?php

namespace Test\DataFixture;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\ORM\EntityManager;
use ZfMetal\Calendar\Entity\Schedule;

class ScheduleLoader extends AbstractFixture implements FixtureInterface
{

    const ENTITY = Schedule::class;


    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ArrayCollection
     */
    protected $schedules;

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
    public function getSchedules()
    {
        if (!$this->schedules) {
            $this->schedules = new ArrayCollection();
        }
        return $this->schedules;
    }


    protected function find($id)
    {
        return $this->getEm()->getRepository($this::ENTITY)->find($id);
    }


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $this->em = $manager;

        $this->createSchedule(1, 1,"CalendarTest");
        $this->createSchedule(2, 2,"CalendarTest");
        $this->createSchedule(3, 3,"CalendarTest");
        $this->createSchedule(4, 4,"CalendarTest");
        $this->createSchedule(5, 5,"CalendarTest");
        $this->createSchedule(6, 6,"CalendarTest");
        $this->createSchedule(7, 7,"CalendarTest");
        $manager->flush();


    }


    public function createSchedule($id, $day,$calendar)
    {

        $schedule = $this->find($id);
        if (!$schedule) {
            $schedule = new Schedule();
            $schedule->setId($id);
            $schedule->setCalendar($this->getReference($calendar));
            $schedule->setDay($day);
            $schedule->setStart(\DateTime::createFromFormat('H:i','09:00'));
            $schedule->setEnd(\DateTime::createFromFormat('H:i','12:00'));
        }

        $this->getEm()->persist($schedule);

        //Add reference for relations
        $this->addReference('schedule'.$id, $schedule);

        $this->getSchedules()->add($schedule);
    }

}