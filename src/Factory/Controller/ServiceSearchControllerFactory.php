<?php

namespace ZfMetal\Calendar\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * AccountControllerFactory
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ServiceSearchControllerFactory implements FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $container->get("doctrine.entitymanager.orm_default");
        return new \ZfMetal\Calendar\Controller\ServiceSearchController($em);
    }


}

