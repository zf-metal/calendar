<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use ZfMetal\Calendar\Repository\ServiceRepository;

/**
 * AccountController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ServiceSearchController extends AbstractRestfulController
{

    const ENTITY = \ZfMetal\Calendar\Entity\Service::class;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    /**
     * @var \ZfMetal\Datagrid\Grid
     */
    public $grid = null;

    public function getEm()
    {
        return $this->em;
    }

    public function setEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return ServiceRepository
     */
    public function getEntityRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    /**
     * @return ServiceRepository
     */
    public function getServiceRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function searchAction()
    {
        $result = [];
        if($this->getRequest()->isPost()){

            //Recibir en JSON Ver Restful Controller
            $id = $this->getRequest()->getPost("id");
            $account = $this->getRequest()->getPost("account");
            $branchOffice = $this->getRequest()->getPost("branchOffice");
            $address =  $this->getRequest()->getPost("address");


            $result =  $this->getServiceRepository()->search($id,$account,$branchOffice,$address);
        }


       return new JsonModel($result);
    }


}

