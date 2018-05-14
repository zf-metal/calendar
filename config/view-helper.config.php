<?php

return array(
    'view_helpers' => array(
        'factories' => array(
            'ZfMetalCalendarOptions' => \ZfMetal\Calendar\Factory\Helper\View\OptionsFactory::class,
            'calendarHelper'=> \ZfMetal\Calendar\Factory\Helper\View\CalendarHelperFactory::class,
            'zfMetal\\CalendarOptions' => \ZfMetal\Calendar\Factory\Helper\View\OptionsFactory::class,
            'zfMetal\\CalendarCalendarHelper' => \ZfMetal\Calendar\Factory\Helper\View\CalendarHelperFactory::class,
        ),
    ),
);