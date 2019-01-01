<?php

namespace ZfMetal\Calendar\Controller;


use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use ZfMetal\Calendar\Repository\EventRepository;
use ZfMetal\Restful\Transformation\Transform;

/**
 * EventSearchController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class EventSearchController extends AbstractRestfulController
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

    public function getEntityRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    /**
     * @return EventRepository
     */
    public function getEventRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function searchByServiceYearMonthAction()
    {

        $service = $this->params("service");
        $year = $this->params("year");
        $month = $this->params("month");

        $objects = $this->getEventRepository()->findByServiceYearMonth($service, $year, $month);

        $transform = new Transform();
        $results = $transform->toArrays($objects);


        return new JsonModel($results);
    }


}

