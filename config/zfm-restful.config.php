<?php

return  [
    'zf-metal-restful.options'  => [
        'entity_aliases' =>  [
            'calendars' => \ZfMetal\Calendar\Entity\Calendar::class,
            'calendar-groups' => \ZfMetal\Calendar\Entity\CalendarGroup::class,
            'events' => \ZfMetal\Calendar\Entity\Event::class,
            'event-states' => \ZfMetal\Calendar\Entity\EventState::class,
            'event-types' => \ZfMetal\Calendar\Entity\EventType::class,
            'zones' => \ZfMetal\Calendar\Entity\Zone::class,

            'accounts' => \ZfMetal\Calendar\Entity\Account::class,
            'branch-offices' => \ZfMetal\Calendar\Entity\BranchOffice::class,
            'services' => \ZfMetal\Calendar\Entity\Service::class,
        ],
    ],
];