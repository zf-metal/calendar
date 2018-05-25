<?php

namespace ZfMetal\Calendar\Controller;

use Indaxia\OTR\Traits\Transformable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
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

    public function getList()
    {

        try {
            $query = $this->getRequest()->getQuery();

            if($query){
                $calendars = $this->getCalendarRepository()->queryFilter($query);
            }else {
                $calendars = $this->getCalendarRepository()->fullList();
            }

            $results = Transform::toArrays($calendars);

            return new JsonModel($results);

        } catch (\Exception $e) {
            $a = [
                "messages" => $e->getMessage()
            ];
            return new JsonModel($a);
        }
    }

    public function get($id = null)
    {

        try {

            if ($id) {
                $object = $this->getEntityRepository()->find($id);
                if (!$object) {
                    throw new ItemNotExistException();
                }
                $results = $object->toArray();
            }

            return new JsonModel($results);
        } catch (ItemNotExistException $e) {
            return $this->responseSpecificException($e);
        } catch (\Exception $e) {
            return $this->responseGeneralException($e);
        }
    }

}

