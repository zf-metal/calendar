<?php


namespace \ZfMetal\Calendar\Service;


class EventService 
{

    const ENTITY = \ZfMetal\Calendar\Entity\Event::class;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    public function getEm()
    {
        return $this->em;
    }

    public function setEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return \ZfMetal\Calendar\Repository\EventRepository
     */
    public function getEntityRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
           $this->em = $em;
    }


    public function getEventsByDay($date){
        $events = $this->getEntityRepository()->findByStart($date);
        $results = Transformable::toArrays($events);
        return $results;
    }

    public function save(){

    }

}
