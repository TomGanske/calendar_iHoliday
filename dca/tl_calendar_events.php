<?php

/**
 * Contao Extension iHoliday
 * Copyright (c) 2015-2016 Tom Ganske
 * author     Tom Ganske (http://ct-eye.com ||  https://github.com/TomGanske)
 * @license   LGPL-3.0+
 */

// Palettes
$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default'] = str_replace
(
    'location',
    'location,event_type',
    $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default']
);

// Fields
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['event_type'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['event_type'],
    'reference'               => &$GLOBALS['TL_LANG']['tl_calendar_events']['event_type']['label'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array(0,1,2,3,4),
    'eval'                    => array('maxlength'=>1, 'tl_class'=>'w50'),
    'sql'                     => "tinyint(1) unsigned NOT NULL default '0'",
);

$GLOBALS['TL_DCA']['tl_calendar_events']['list']['global_operations']['setup'] =
    array(
        'label'               => &$GLOBALS['TL_LANG']['MSC']['calendar_setup'],
        'href'                => 'key=importExt',
        'class'               => 'header_import',
        'attributes'          => 'onclick="Backend.getScrollOffset();"'
    );