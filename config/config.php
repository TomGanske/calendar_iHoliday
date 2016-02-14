<?php

/**
 * Contao Extension iHoliday
 * Copyright (c) 2015-2016 Tom Ganske
 * author     Tom Ganske (http://ct-eye.com ||  https://github.com/TomGanske)
 * @license   LGPL-3.0+
 */

/**
 * Extension version
 */
@define('iHoliday_VERSION', '1.1');
@define('iHoliday_BUILD', '0');

/**
 * Front end modules
 */
array_insert($GLOBALS['FE_MOD'], 2, array
(
	'events' => array
	(
		'calendar_iHoliday'     => 'ModuleIHolidayCalendar',
        'eventlist_iHoliday'    => 'ModuleEventlistIHoliday'
	)
));

$GLOBALS['BE_MOD']['content']['calendar']['importExt'] = array('CalendarImportExt', 'importExt');