<?php

namespace ZfMetal\Calendar\Controller;

use Indaxia\OTR\Traits\Transformable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * ApiEventController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ApiEventController extends AbstractRestfulController
{

    const ENTITY = '\\ZfMetal\\Calendar\\Entity\\Event';

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

    public function getEventRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }



}

