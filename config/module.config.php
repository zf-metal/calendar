<?php

$setting = array_merge_recursive(
include "controller.config.php",
include "doctrine.config.php",
include "form.config.php",
include "plugins.config.php",
include "route.config.php",
include "services.config.php",
include "view-helper.config.php",
include "view.config.php",
include "zfm-datagrid.calendar.config.php",
include "zfm-datagrid.event.config.php",
include "zfm-datagrid.holiday.config.php",
include "zfm-datagrid.ticket-state.config.php",
include "zfm-restful.config.php"
);

return $setting;
