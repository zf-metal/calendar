<?php

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

/**
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
return [
    
    'console' => array(
        'router' => array(
            'routes' => array(
                'initcalendar' => array(
                    'options' => array(
                        // add [ and ] if optional ( ex : [<doname>] )
                        'route' => 'initcalendar ',
                        'defaults' => array(
                            'controller' => \ZfMetal\Calendar\Controller\InitController::class,
                            'action' => 'init'
                        ),
                    ),
                ),
            ),
        ),
    ),
];
