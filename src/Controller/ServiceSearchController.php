<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Http\Request;
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

            $data = $this->getData($this->getRequest());

            //Data
            $id = array_key_exists("id",$data)?$data["id"]:null;
            $client = array_key_exists("client",$data)?$data["client"]:null;
            $branchOffice = array_key_exists("branchOffice",$data)?$data["branchOffice"]:null;;
            $location =  array_key_exists("location",$data)?$data["location"]:null;;


            $result =  $this->getServiceRepository()->search($id,$client,$branchOffice,$location);
        }

       return new JsonModel($result);
    }


    protected function getData(Request $request)
    {
        if ($this->requestHasContentType($request, self::CONTENT_TYPE_JSON)) {
            return $this->jsonDecode($request->getContent());
        }

        return $request->getPost()->toArray();
    }


}

