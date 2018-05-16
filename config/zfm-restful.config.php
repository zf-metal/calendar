<?php

return array(
    'zf-metal-restful.options'  => array(
        'entity_aliases' => array(
            'calendars' => \ZfMetal\Calendar\Entity\Calendar::class,
            'tickets' => \ZfMetal\Calendar\Entity\Ticket::class,
            'events' => \ZfMetal\Calendar\Entity\Event::class,
        ),
    ),
);