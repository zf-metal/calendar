<?php

return  [
    'zf-metal-restful.options'  => [
        'entity_aliases' =>  [
            'calendars' => \ZfMetal\Calendar\Entity\Calendar::class,
            'events' => \ZfMetal\Calendar\Entity\Event::class,
            'event-states' => \ZfMetal\Calendar\Entity\EventState::class,
            'event-types' => \ZfMetal\Calendar\Entity\EventType::class,
        ],
    ],
];