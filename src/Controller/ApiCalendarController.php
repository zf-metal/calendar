<?php

namespace ZfMetal\Calendar\Controller;

use Indaxia\OTR\Traits\Transformable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use ZfMetal\Calendar\Entity\Calendar;
use ZfMetal\Calendar\Repository\CalendarRepository;
use ZfMetal\Restful\Transformation\Transform;

/**
 * ApiCalendarController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ApiCalendarController extends AbstractRestfulController
{

    const ENTITY = Calendar::class;

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
     * @return CalendarRepository
     */
    public function getCalendarRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }




}

