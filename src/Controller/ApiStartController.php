<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use ZfMetal\Calendar\Entity\Calendar;
use ZfMetal\Calendar\Entity\CalendarGroup;
use ZfMetal\Calendar\Entity\EventState;
use ZfMetal\Calendar\Entity\EventType;
use ZfMetal\Calendar\Entity\Zone;
use ZfMetal\Restful\Options\ModuleOptions;
use ZfMetal\Restful\Transformation\Transform;

/**
 * ApiStartController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ApiStartController extends AbstractRestfulController
{

    const ENTITY = \ZfMetal\Calendar\Entity\Calendar::class;

    const CALENDAR = Calendar::class;
    const CALENDAR_GROUPS = CalendarGroup::class;
    const ZONE = Zone::class;
    const EVENT_STATE = EventState::class;
    const EVENT_TYPE = EventType::class;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;


    /**
     * @return ModuleOptions
     */
    public function getRestfulOptions(){
        return $this->zfMetalRestfulOptions();
    }

    /**
     * @return array
     */
    public function getEntityAliases(){
       return $this->getRestfulOptions()->getEntityAliases();
    }

    public function getEntityByAlias($alias){
        $a = $this->getEntityAliases();
        if(key_exists($alias,$a)){
            return $a[$alias];
        }
        switch ($alias){
            case "zones":
                return $this::ZONE;
            case "calendars":
                return $this::CALENDAR;
            case "event-states":
                return $this::EVENT_STATE;
            case "event-types":
                return $this::EVENT_TYPE;
            case "calendar-groups":
                return $this::CALENDAR_GROUPS;
        }
    }


    public function getEm()
    {
        return $this->em;
    }

    public function setEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEventStateRepository()
    {
        return $this->getEm()->getRepository($this->getEntityByAlias('event-states'));
    }


    public function getEventTypeRepository()
    {
        return $this->getEm()->getRepository($this->getEntityByAlias('event-types'));
    }

    public function getZoneRepository()
    {
        return $this->getEm()->getRepository($this->getEntityByAlias('zones'));
    }

    public function getCalendarRepository()
    {
        return $this->getEm()->getRepository($this->getEntityByAlias('calendars'));
    }

    public function getCalendarGroupsRepository()
    {
        return $this->getEm()->getRepository($this->getEntityByAlias('calendar-groups'));
    }

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function getList(){

        try {
            $transform = new Transform();


            $calendars = $this->getCalendarRepository()->findAll();
            $calendars = $transform->toArrays($calendars);

            $calendarGroups = $this->getCalendarGroupsRepository()->findAll();
            $calendarGroups = $transform->toArrays($calendarGroups);

            $zones = $this->getZoneRepository()->findAll();
            $zones =$transform->toArrays($zones);

            $eventStates = $this->getEventStateRepository()->findAll();
            $eventStates = $transform->toArrays($eventStates);

            $eventTypes = $this->getEventTypeRepository()->findAll();
            $eventTypes = $transform->toArrays($eventTypes);

            $results['calendars'] = $calendars;
            $results['zones'] = $zones;
            $results['eventStates'] = $eventStates;
            $results['eventTypes'] = $eventTypes;
            $results['calendarGroups'] = $calendarGroups;

            return new JsonModel($results);

        } catch (\Exception $e) {
            $a = [
                "messages" => $e->getMessage()
            ];
            return new JsonModel($a);
        }
    }
}

