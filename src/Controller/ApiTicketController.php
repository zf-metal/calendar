<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use ZfMetal\Calendar\Entity\Ticket;
use ZfMetal\Restful\Controller\AbstractRestfulController;
use ZfMetal\Restful\Controller\MainController;

/**
 * ApiTicketController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ApiTicketController extends MainController
{

    const ENTITY = '\\ZfMetal\\Calendar\\Entity\\Ticket';

    /**
     * @var string
     */
    protected $entityClass = Ticket::class;


    /**
     * @var string
     */
    protected $entityAlias = "tickets";

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
        return $this->getEm()->getRepository($this->getEntityClass());
    }

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @return string
     */
    public function getEntityAlias()
    {
        return $this->entityAlias;
    }



}

