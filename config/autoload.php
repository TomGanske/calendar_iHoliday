<?php

/**
 * Contao Extension iHoliday
 * Copyright (c) 2015-2016 Tom Ganske
 * author     Tom Ganske (http://ct-eye.com ||  https://github.com/TomGanske)
 * @license   LGPL-3.0+
 */

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Contao\ModuleIHolidayCalendar'      => 'system/modules/calendar_iHoliday/modules/ModuleIHolidayCalendar.php',
    'Contao\ModuleEventlistIHoliday'     => 'system/modules/calendar_iHoliday/modules/ModuleEventlistIHoliday.php',
    'Contao\CalendarImportExt'           => 'system/modules/calendar_iHoliday/classes/CalendarImportExt.php'

));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'cal_full'              => 'system/modules/calendar_iHoliday/templates',
    'cal_single'            => 'system/modules/calendar_iHoliday/templates',
    'event_list_iHoliDay'   => 'system/modules/calendar_iHoliday/templates',
    'mod_calendarYear'      => 'system/modules/calendar_iHoliday/templates',
    'mod_eventlist_iHoliDay'=> 'system/modules/calendar_iHoliday/templates',
    'be_importExt_calendar' => 'system/modules/calendar_iHoliday/templates'

));