<?php

namespace ZfMetal\Calendar\Factory\Helper\View;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * CalendarHelperFactory
 *
 *
 *
 * @author
 * @license
 * @link
 */
class CalendarHelperFactory implements FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        return new \ZfMetal\Calendar\Helper\View\CalendarHelper();
    }


}

