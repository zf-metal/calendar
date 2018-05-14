<?php

namespace ZfMetal\Calendar\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Indaxia\OTR\Traits\Transformable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZfMetal\Calendar\Entity\Calendar;
use ZfMetal\Calendar\Repository\CalendarRepository;

/**
 * CalendarApiController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class CalendarApiController extends AbstractActionController
{

    const ENTITY = '\\ZfMetal\\Calendar\\Entity\\Calendar';

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

    public function getEntityRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    /**
     * @return CalendarRepository
     */
    public function getCalendarRepository()
    {
        return $this->getEm()->getRepository(Calendar::class);
    }

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function listAction()
    {
        try {
            $calendars = $this->getCalendarRepository()->fullList();

            $results = Transformable::toArrays($calendars);


            $a = [
                "success" => true,
                "data" => $results
            ];
            return new JsonModel($a);
        } catch (\Exception $e) {
            $a = [
                "success" => fale,
                "message" => $e->getMessage()
            ];
            return new JsonModel($a);
        }

    }


}

