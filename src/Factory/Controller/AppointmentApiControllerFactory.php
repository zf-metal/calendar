<?php

namespace ZfMetal\Calendar\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\Calendar\Form\AppointmentForm;
use ZfMetal\Calendar\Service\AppointmentService;

/**
 * AppointmentApiControllerFactory
 *
 *
 *
 * @author
 * @license
 * @link
 */
class AppointmentApiControllerFactory implements FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $container->get("doctrine.entitymanager.orm_default");
        $form = $container->get("FormElementManager")->get(AppointmentForm::class);
        $appointmentService = $container->get(AppointmentService::class);
        return new \ZfMetal\Calendar\Controller\AppointmentApiController($em,$form,$appointmentService);
    }


}

