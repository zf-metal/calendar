<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZfMetal\Calendar\Entity\Appointment;
use ZfMetal\Calendar\Form\AppointmentForm;
use ZfMetal\Calendar\Repository\AppointmentRepository;
use ZfMetal\Calendar\Service\AppointmentService;
use ZfMetal\Restful\Model\Response;
/**
 * AppointmentApiController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class AppointmentApiController extends AbstractActionController
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
     * @var AppointmentService
     */
    protected $appointmnetService;

    /**
     * AppointmentController constructor.
     * @param \Doctrine\ORM\EntityManager $em
     * @param AppointmentForm $form
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, AppointmentForm $form, AppointmentService $appointmentService)
    {
        $this->em = $em;
        $this->form = $form;
        $this->appointmnetService = $appointmentService;
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


    public function availableAction()
    {

        //Obtengo parametros
        $calendarId = $this->params('calendarId');
        $date = $this->params('date');

        $appointments = $this->appointmnetService->getAvailableShift($calendarId, $date);


        return new JsonModel($appointments->toArray());
    }


    public function myAppointmentsAction()
    {

        if(!$this->getJwtIdentity()){
            throw new \Exception("Usuario no autenticado");
        }

        $userId = $this->getJwtIdentity()->getId();

        $appointments = $this->getAppointmentRepository()->findMyActiveAppointments($userId);
        $items = [];
        if($appointments) {
            /** @var Appointment $appointment */
            foreach ($appointments as $appointment) {
                $items[] = $appointment->toArray();
            }
        }

        return new JsonModel($items);
    }



    public function cancelAction()
    {
        $response = new Response();
        $appointmentId = $this->params('id');

        /** @var Appointment $appointment */
        $appointment = $this->getAppointmentRepository()->find($appointmentId);
        $appointment->setCanceled(true);
        $this->getAppointmentRepository()->save($appointment);
        $response->setStatus(true);
      //  $response->setItem($appointment->toArray());
        $response->setMessage("El turno ha sido cancelado");

        return new JsonModel($response->toArray());
    }

    public function createAction()
    {
        $response = new Response();


        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();

            if(!$this->getJwtIdentity()){
            throw new \Exception("Usuario no autenticado");
            }

            $data['user'] = $this->getJwtIdentity()->getId();

            $appointment = new Appointment();
            $this->form->bind($appointment);
            $this->form->setData($data);

            if ($this->form->isValid()) {


                //SET END DATE
                $end = clone $appointment->getStart();
                $end->modify("+".$appointment->getDuration()." minutes");
                $appointment->setEnd($end);

                //Check Calendar range time config

                //Check Availability
                if ($this->getAppointmentRepository()
                    ->checkAvailability(
                        $appointment->getCalendar(), $appointment->getStart(), $appointment->getEnd()
                    )
                ) {
                    $this->getAppointmentRepository()->save($appointment);
                    $response->setStatus(true);
                    $response->setItem($appointment->toArray());
                    $response->setMessage("Su turno ha sido confirmado satisfactoriamente.");

                } else {
                    $response->setMessage("Lo sentimos. El turno solicitado ya no esta disponible.");
                }

            } else {
                foreach ($this->form->getMessages() as $key => $messages) {
                    foreach ($messages as $msj) {
                        $response->addError($key,$msj);
                    }
                }
                $response->setMessage("Datos invalidos");
            }


        } else {
            $response->setMessage("Post method is required");
        }



        return new JsonModel($response->toArray());

    }


}

