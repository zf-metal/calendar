<?php

namespace ZfMetal\Calendar\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Indaxia\OTR\Traits\Transformable;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZfMetal\Calendar\Entity\AppointmentConfig;
use ZfMetal\Calendar\Entity\Calendar;
use ZfMetal\Calendar\Entity\PredefinedEvents;
use ZfMetal\Calendar\Entity\Schedule;
use ZfMetal\Calendar\Repository\CalendarRepository;
use ZfMetal\Restful\Controller\MainController;
use ZfMetal\Log\Facade\Logger;
use ZfMetal\Restful\Exception\DataBaseException;
use ZfMetal\Restful\Exception\ValidationException;
use ZfMetal\Restful\Transformation\Transform;
/**
 * CalendarApiController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class CalendarApiController extends MainController
{

    const ENTITY = Calendar::class;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    /**
     * @var CalendarForm
     */
    public $calendarForm = null;

    /**
     * @return string
     * @throws \Exception
     */
    public function getEntityClass()
    {
        return self::ENTITY;
    }

    public function getEntityAlias(){
        $this->entityAlias = "calendars";
        return  $this->entityAlias;
    }

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

    public function __construct(\Doctrine\ORM\EntityManager $em, $form)
    {
        $this->em = $em;
        $this->calendarForm = $form;
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
                "success" => false,
                "message" => $e->getMessage()
            ];
            return new JsonModel($a);
        }

    }

    public function activeAction()
    {
        try {
            $calendars = $this->getCalendarRepository()->findActives();

            $transform = new Transform($this->getEntityLocalPolicies());
            $results = $transform->toArrays($calendars);

            return new JsonModel($results);
        } catch (\Exception $e) {
            $a = [
                "success" => false,
                "message" => $e->getMessage()
            ];
            return new JsonModel($a);
        }

    }

    public function create($data)
    {
        $response = new \ZfMetal\Restful\Model\Response();

        try {
            $object = $this->buildCalendar();
            $this->calendarForm->bind($object);
            $this->calendarForm->setData($data);

            if ($this->calendarForm->isValid()) {
                $this->getEventManager()->trigger('create_' . $this->getEntityAlias() . '_before', $this, ["object" => $object]);
                try {
                    $this->getEm()->persist($object);
                    $this->getEm()->flush();
                } catch (\Exception $e) {
                    Logger::exception($e);
                    throw new DataBaseException();
                }
                $this->getEventManager()->trigger('create_' . $this->getEntityAlias() . '_after', $this, ["object" => $object]);
                $response->setStatus(true);
            } else {
                foreach ($this->calendarForm->getMessages() as $key => $messages) {
                    foreach ($messages as $msj) {
                        $response->addError($key, $msj);
                    }
                }
                $response->setStatus(false);
            }

            if (!$response->getStatus()) {
                throw new ValidationException();
            } else {
                $response->setMessage("The item was created successfully");
            }

            $response->setId($object->getId());


            if ($this->zfMetalRestfulOptions()->getReturnItemOnUpdate()) {
                $transform = new Transform($this->getEntityLocalPolicies());
                $item = $transform->toArray($object);
                $response->setItem(json_encode($item));

            }

            $this->getResponse()->setStatusCode(Response::STATUS_CODE_201);

            return new JsonModel($response->toArray());

        } catch (ValidationException $e) {
            return $this->responseValidationException($e, $response->getErrors());
        } catch (DataBaseException $e) {
            return $this->responseDataBaseException($e);
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            $response->setStatus(false);
            $response->setMessage($e->getMessage());
            return new JsonModel($response->toArray());
        }
    }


    public function update($id, $data)
    {

        $response = new \ZfMetal\Restful\Model\Response();


        try {


            $object = $this->getEntityRepository()->find($id);
            if (!$object) {
                throw new ItemNotExistException();
            }


            $this->calendarForm->bind($object);
            $this->calendarForm->setData($data);

            if ( $this->calendarForm->isValid()) {
                $this->getEventManager()->trigger('update_' . $this->getEntityAlias() . '_before', $this, ["object" => $object]);
                try {
                    $this->getEm()->persist($object);
                    $this->getEm()->flush();
                } catch (\Exception $e) {
                    Logger::exception($e);
                    throw new DataBaseException();
                }
                $this->getEventManager()->trigger('update_' . $this->getEntityAlias() . '_after', $this, ["object" => $object]);
                $response->setStatus(true);
            } else {
                foreach ( $this->calendarForm->getMessages() as $key => $messages) {
                    foreach ($messages as $msj) {
                        $response->addError($key, $msj);
                    }
                }
                $response->setStatus(false);
            }

            if (!$response->getStatus()) {
                throw new ValidationException();
            } else {
                $response->setMessage("The item was updated successfully");
            }

            $response->setId($object->getId());


            if ($this->zfMetalRestfulOptions()->getReturnItemOnUpdate()) {
                $transform = new Transform($this->getEntityLocalPolicies());
                $item = $transform->toArray($object);
                $response->setItem(json_encode($item));

            }

            $this->getResponse()->setStatusCode(Response::STATUS_CODE_200);

            return new JsonModel($response->toArray());
        } catch (DataBaseException $e) {
            return $this->responseDataBaseException($e);
        } catch (ItemNotExistException $e) {
            return $this->responseSpecificException($e);
        } catch (ValidationException $e) {
            return $this->responseValidationException($e, $response->getErrors());
        } catch (\Exception $e) {
            return $this->responseGeneralException($e);
        }

    }


    protected function buildCalendar()
    {
        $id = $this->params("id");
        if ($id) {
            $calendar = $this->getCalendarRepository()->find($id);
            if (!$calendar) {
                throw new \Exception("Calendar doesn´t exist");
            }

            if(!$calendar->getAppointmentConfig()){
                $calendar->setAppointmentConfig(new AppointmentConfig());
            }

        } else {
            $calendar = new Calendar();
            $calendar->addSchedule($this->buildSchedule($calendar, 1));
            $calendar->addSchedule($this->buildSchedule($calendar, 2));
            $calendar->addSchedule($this->buildSchedule($calendar, 3));
            $calendar->addSchedule($this->buildSchedule($calendar, 4));
            $calendar->addSchedule($this->buildSchedule($calendar, 5));
            $calendar->addSchedule($this->buildSchedule($calendar, 6));
            $calendar->addSchedule($this->buildSchedule($calendar, 7));
            $calendar->addSchedule($this->buildSchedule($calendar, 8));
            $calendar->setAppointmentConfig(new AppointmentConfig());
        }

        return $calendar;
    }

    protected function buildSchedule($calendar, $day)
    {
        $schedule = new Schedule();
        $schedule->setDay($day);
        return $schedule;
    }
}

