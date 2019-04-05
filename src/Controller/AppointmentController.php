<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZfMetal\Calendar\Entity\Appointment;
use ZfMetal\Calendar\Form\AppointmentForm;
use ZfMetal\Calendar\Repository\AppointmentRepository;
use ZfMetal\Restful\Model\Response;

/**
 * AppointmentController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class AppointmentController extends AbstractActionController
{

    const ENTITY = \ZfMetal\Calendar\Entity\Appointment::class;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    /**
     * @var AppointmentForm
     */
    public $form;

    /**
     * AppointmentController constructor.
     * @param \Doctrine\ORM\EntityManager $em
     * @param AppointmentForm $form
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, AppointmentForm $form)
    {
        $this->em = $em;
        $this->form = $form;
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
     * @return AppointmentRepository
     */
    public function getAppointmentRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }





}

