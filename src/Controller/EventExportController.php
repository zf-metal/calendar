<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * EventExportController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class EventExportController extends AbstractActionController
{

    const ENTITY = 'ZfMetal\\Calendar\\Entity\\Event';

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

    public function getEventRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function excelAction()
    {
        $date = $this->param("date");

        return [];
    }


}

