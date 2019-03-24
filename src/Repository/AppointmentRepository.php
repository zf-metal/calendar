<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;
use Zend\Form\Element\DateTime;
use ZfMetal\Calendar\Entity\Appointment;

/**
 * AppointmentRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class AppointmentRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\Appointment $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\Appointment $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


    /**
     * @return array
     */
    public function checkAvailability($calendar, $start, $end)
    {
        $result =  $this->getEntityManager()->createQueryBuilder('u')
            ->select('u')
            ->from(Appointment::class, 'u')
            ->where(' 
               (u.start > :start AND u.start < :end) 
            OR (u.end > :start AND u.end < :end) 
            OR (u.start < :start AND u.end > :end) 
            OR (u.start = :start AND u.end = :end)
            ')
            ->andWhere('u.calendar = :calendar')
            ->andWhere('u.status = 1')
            ->setParameter("calendar", $calendar)
            ->setParameter("start",$start)
            ->setParameter("end", $end)
            ->getQuery()
            ->getResult();

        return ($result)?false:true;


    }

    public function checkIfUserHasAnotherAppointmentForTheSameCalendar($calendar, $user)
    {
        $now = new \DateTime();
        $result =  $this->getEntityManager()->createQueryBuilder('u')
            ->select('u')
            ->from(Appointment::class, 'u')
            ->where('u.start > :now')
            ->andWhere('u.calendar = :calendar')
            ->andWhere('u.user = :user')
            ->andWhere('u.status = 1')
            ->setParameter("calendar", $calendar)
            ->setParameter("now",$now)
            ->setParameter("user", $user)
            ->getQuery()
            ->getResult();

        return ($result)?true:false;


    }


    public function findMyActiveAppointments($userId)
    {
        $start = new \DateTime();
        return  $this->getEntityManager()->createQueryBuilder('u')
            ->select('u')
            ->from(Appointment::class, 'u')
            ->where('u.user = :userid')
            ->andWhere('u.start > :start')

            //Appointment start (ex: cancelado)
            ->setParameter("userid", $userId)
            ->setParameter("start",$start)
            ->getQuery()
            ->getResult();


    }
}

