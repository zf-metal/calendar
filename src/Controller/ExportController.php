<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use ZfMetal\Calendar\Entity\Event;

/**
 * ExportController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ExportController extends AbstractActionController
{

    const ENTITY = \ZfMetal\Calendar\Entity\Event::class;

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

    public function eventsAction()
    {
        //Format Y-m-d
        $date = $this->params("date");
        //Format H
        $hourStart = $this->params("hourStart");
        //Format H
        $hourEnd = $this->params("hourEnd");


        $from = new \DateTime($date . " " . $hourStart);
        $to = new \DateTime($date);
        $to->modify("+1 day");
        $to->modify("+" . $hourEnd . " hours");

        $events = $this->getEventRepository()->exportDaily($from, $to);

        $calendar = [];
        /** @var Event $event */
        foreach ($events as $event) {
            $calendars[$event->getCalendar()->getId()]["calendar"] = $event->getCalendar();
            $calendars[$event->getCalendar()->getId()]["events"] = $event;
        }


        $header = array(
            'IdVisita' => 'integer',
            'HoraInicio' => 'string',
            'HoraFin' => 'string',
            'Zona' => 'string',
            'Cliente' => 'string',
            'Sucursal' => 'string',
            'Direccion' => 'string',
            'Servicio' => 'string',
            'IdServicio' => 'integer',
        );

        $writer = new \XLSXWriter();
        foreach ($calendars["calendar"] as $id => $calendar) {


            $data = [];
            foreach ($calendar["events"] as $event) {
                $data[] = array(
                    $event->getId(),
                    $event->getStart()->format("H:i"),
                    $event->getEnd()->format("H:i"),
                    $event->getZone()->getName(),
                    $event->getClient()->getName(),
                    $event->getService()->getSucursal()->getName(),
                    $event->getService()->getSucursal()->getAddress(),
                    $event->getService()->getName(),
                    $event->getService()->getId(),
                );
            }

            $writer->writeSheetHeader($calendar->getName(), $header);
            $writer->writeSheet($calendar->getName(), $data);
        }

        $fileName = "Export.xlsx";

        $file = $writer->writeToString();
        $response = $this->getResponse();
        $response->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
        ));
        $response->setContent($file);
        return $response;
    }


}

