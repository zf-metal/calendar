<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZfMetal\Calendar\Entity\Appointment;
use ZfMetal\Calendar\Form\AppointmentForm;
use ZfMetal\Calendar\Options\ModuleOptions;
use ZfMetal\Calendar\Repository\AppointmentRepository;
use ZfMetal\Calendar\Service\AppointmentService;
use ZfMetal\Mail\MailManager;
use ZfMetal\Restful\Model\Response;
use ZfMetal\Restful\Transformation\Transform;
use ZfMetal\Security\Entity\User;

/**
 * AppointmentApiController
 *
 *
 *
 * @author
 * @license
 * @link
 * @method ModuleOptions ZfMetalCalendarOptions()
 * @method \ZfMetal\Mail\Options\ModuleOptions ZfMetalMailOptions()
 * @method MailManager mailManager()
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

        if (!$this->getJwtIdentity()) {
            throw new \Exception("Usuario no autenticado");
        }

        $userId = $this->getJwtIdentity()->getId();

        $appointments = $this->getAppointmentRepository()->findMyActiveAppointments($userId);
        $items = [];
        if ($appointments) {
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

        $calendar = $appointment->getCalendar();

        $now = new \DateTime();
        $diff = $this->calculateHoursDiff($appointment->getStart(), $now);


        $cancelTime = $calendar->getAppointmentConfig()->getCancelTimeInHours();

        if(!$cancelTime){
            $cancelTime = 0;
        }

        if ($diff < 0) {
            $response->setStatus(false);
            $response->setMessage("El turno ha caducado");
            $this->logger()->warn("Turnos Caducado. DIFF: ".$diff. " NOW: ".$now->format("Y-m-d H:i:s")." (".$now->getTimestamp(). ") START: ".$appointment->getStart()->format("Y-m-d H:i:s")." (".$appointment->getStart()->getTimestamp().")");
        } else if ($cancelTime < $diff) {
            $appointment->cancelByUser();
            $this->getAppointmentRepository()->save($appointment);

            if ($this->ZfMetalCalendarOptions()->getAppointmentEmailNotify()) {
                $this->appointmentEmailNotifyCancel($appointment);
            }

            $transform = new Transform();
            $item = $transform->toArray($appointment);
            $response->setItem($item);
            $response->setStatus(true);
            $response->setMessage("El turno ha sido cancelado");

        } else {
            $response->setStatus(false);
            $response->setMessage("No es posible cancelar el turno. Tiempo requerido: " . $cancelTime . "hs");
        }


        return new JsonModel($response->toArray());
    }

    protected function calculateHoursDiff(\DateTime $date1, \DateTime $date2)
    {
        return round($date1->getTimestamp() - $date2->getTimestamp(), 0, PHP_ROUND_HALF_DOWN) / 3600;
    }

    public function createAction()
    {
        $response = new Response();


        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();

            if (!$this->getJwtIdentity()) {
                throw new \Exception("Usuario no autenticado");
            }

            //TODO: check the permission of the user (need be administrator)
            if (!isset($data['user'])) {
                $data['user'] = $this->getJwtIdentity()->getId();
            }

            $appointment = new Appointment();
            $this->form->bind($appointment);
            $this->form->setData($data);

            if ($this->form->isValid()) {


                //SET END DATE
                $end = clone $appointment->getStart();
                $end->modify("+" . $appointment->getDuration() . " minutes");
                $appointment->setEnd($end);


                //TODO: Check Calendar range time config


                //Check 1 appointment per User for the same calendar
                $hasAnotherAppointment = $this->getAppointmentRepository()->checkIfUserHasAnotherAppointmentForTheSameCalendar(
                    $appointment->getCalendar(), $appointment->getUser()
                );

                if ($hasAnotherAppointment) {
                    $response->setMessage("Ya cuenta con un turno pendiente para esta agenda. No es posible acumular turnos.");
                } else {

                    //Check Availability
                    $hasAvailability = $this->getAppointmentRepository()->checkAvailability(
                        $appointment->getCalendar(), $appointment->getStart(), $appointment->getEnd()
                    );


                    if ($hasAvailability) {

                        $this->getAppointmentRepository()->save($appointment);
                        $response->setStatus(true);
                        $response->setItem($appointment->toArray());
                        $response->setMessage("Su turno ha sido confirmado satisfactoriamente.");

                        if ($this->ZfMetalCalendarOptions()->getAppointmentEmailNotify()) {
                            $this->appointmentEmailNotifyConfirm($appointment);
                        }

                    } else {
                        $response->setMessage("Lo sentimos. El turno solicitado ya no esta disponible.");
                    }
                }

            } else {
                foreach ($this->form->getMessages() as $key => $messages) {
                    foreach ($messages as $msj) {
                        $response->addError($key, $msj);
                    }
                }
                $response->setMessage("Datos invalidos");
            }


        } else {
            $response->setMessage("Post method is required");
        }


        return new JsonModel($response->toArray());

    }


    public function appointmentEmailNotifyConfirm(Appointment $appointment)
    {

        $params = [
            "title" => $this->ZfMetalCalendarOptions()->getAppointmentEmailTitle(),
            "backgroundColorTitle" => $this->ZfMetalCalendarOptions()->getAppointmentEmailBackgroundColorTitle(),
            "colorTitle" => $this->ZfMetalCalendarOptions()->getAppointmentEmailColorTitle(),
            "signature" => $this->ZfMetalCalendarOptions()->getAppointmentEmailSignature(),
            "url" => $this->ZfMetalCalendarOptions()->getAppointmentEmailUrl(),
            "nombre" => $appointment->getUser()->getName(),
            "agenda" => $appointment->getCalendar()->getName(),
            "fecha" => $appointment->getStart()->format("d-m-Y"),
            "horario" => $appointment->getStart()->format("H:i")

        ];

        $this->mailManager()->setTemplate('zf-metal/calendar/mails/appointment-confirm', $params);

        $this->mailManager()->setFrom($this->ZfMetalMailOptions()->getDefaultFrom());

        $this->mailManager()->addTo($appointment->getUser()->getEmail(), $appointment->getUser()->getName());


        $this->mailManager()->setSubject('Confirmación de Turno #'.$appointment->getId());

        if ($this->mailManager()->send()) {
            return true;
        } else {
            $this->logger()->info("Falla al enviar mail de confirmacion de turno");
            return false;
        }


    }

    public function appointmentEmailNotifyCancel(Appointment $appointment)
    {

        $params = [
            "title" => $this->ZfMetalCalendarOptions()->getAppointmentEmailTitle(),
            "backgroundColorTitle" => $this->ZfMetalCalendarOptions()->getAppointmentEmailBackgroundColorTitle(),
            "colorTitle" => $this->ZfMetalCalendarOptions()->getAppointmentEmailColorTitle(),
            "signature" => $this->ZfMetalCalendarOptions()->getAppointmentEmailSignature(),
            "url" => $this->ZfMetalCalendarOptions()->getAppointmentEmailUrl(),
            "nombre" => $appointment->getUser()->getName(),
            "agenda" => $appointment->getCalendar()->getName(),
            "fecha" => $appointment->getStart()->format("d-m-Y"),
            "horario" => $appointment->getStart()->format("H:i")

        ];

        $this->mailManager()->setTemplate('zf-metal/calendar/mails/appointment-cancel', $params);

        $this->mailManager()->setFrom($this->ZfMetalMailOptions()->getDefaultFrom());

        $this->mailManager()->addTo($appointment->getUser()->getEmail(), $appointment->getUser()->getName());


        $this->mailManager()->setSubject('Cancelación de Turno #'.$appointment->getId());

        if ($this->mailManager()->send()) {
            return true;
        } else {
            $this->logger()->info("Falla al enviar mail de cancelacion de turno");
            return false;
        }


    }

}

