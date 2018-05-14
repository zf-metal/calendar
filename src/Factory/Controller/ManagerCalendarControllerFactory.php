<?php

namespace ZfMetal\Calendar\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\Calendar\Form\CalendarForm;

/**
 * ManagerCalendarControllerFactory
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ManagerCalendarControllerFactory implements FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $container->get("doctrine.entitymanager.orm_default");

        $form = $container->get('FormElementManager')->get(CalendarForm::class);
        return new \ZfMetal\Calendar\Controller\ManagerCalendarController($em,$form);
    }


}

