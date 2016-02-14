<?php

/**
 * Contao Extension iHoliday
 * Copyright (c) 2015-2016 Tom Ganske
 * author     Tom Ganske (http://ct-eye.com ||  https://github.com/TomGanske)
 * @license   LGPL-3.0+
 */

// Palettes 
$GLOBALS['TL_DCA']['tl_module']['palettes']['calendar_iHoliday']    = '{title_legend},name,headline,type;{config_legend},cal_calendar,cal_noSpan,cal_startDay;{showCal_legend},start_year,start_show_month,end_show_month,bg_closing_color,c_closing_color,bg_event_color,c_event_color,bg_holiday_color,c_holiday_color,bg_publicHoliday_color,c_publicHoliday_color;{redirect_legend},jumpTo;{template_legend:hide},cal_ctemplate,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['eventlist_iHoliday']   = '{title_legend},name,headline,type;{config_legend},cal_calendar,cal_noSpan,cal_format,cal_ignoreDynamic,cal_order,cal_readerModule,cal_limit,perPage,progress_active,progress_future;{template_legend:hide},cal_template,customTpl;{image_legend:hide},imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

// Fields
$GLOBALS['TL_DCA']['tl_module']['fields']['start_year'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['start_year'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class'=>'clr'),
    'sql'                     => "char(4) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['start_show_month'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['start_show_month'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'				  => array(1,2,3,4,5,6,7,8,9,10,11,12),
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "tinyint(2) unsigned NOT NULL default '1'"
);
	
$GLOBALS['TL_DCA']['tl_module']['fields']['end_show_month'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['end_show_month'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'				  => array(1,2,3,4,5,6,7,8,9,10,11,12),
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "tinyint(2) unsigned NOT NULL default '12'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bg_closing_color'] = array
(
    'label'				      => &$GLOBALS['TL_LANG']['tl_module']['bg_closing_color'],
    'inputType'			      => 'text',
    'exclude'			      => true,
    'eval'                    => array('maxlength'=>6, 'multiple'=>true, 'size'=>2, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['c_closing_color'] = array
(
    'label'				      => &$GLOBALS['TL_LANG']['tl_module']['c_event_color'],
    'inputType'			      => 'text',
    'exclude'			      => true,
    'eval'                    => array('maxlength'=>6, 'multiple'=>true, 'size'=>2, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bg_event_color'] = array
(
    'label'				      => &$GLOBALS['TL_LANG']['tl_module']['bg_event_color'],
    'inputType'			      => 'text',
    'exclude'			      => true,
    'eval'                    => array('maxlength'=>6, 'multiple'=>true, 'size'=>2, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['c_event_color'] = array
(
    'label'				      => &$GLOBALS['TL_LANG']['tl_module']['c_event_color'],
    'inputType'			      => 'text',
    'exclude'			      => true,
    'eval'                    => array('maxlength'=>6, 'multiple'=>true, 'size'=>2, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bg_holiday_color'] = array
(
    'label'				      => &$GLOBALS['TL_LANG']['tl_module']['bg_holiday_color'],
    'inputType'			      => 'text',
    'exclude'			      => true,
    'eval'                    => array('maxlength'=>6, 'multiple'=>true, 'size'=>2, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['c_holiday_color'] = array
(
    'label'				      => &$GLOBALS['TL_LANG']['tl_module']['c_holiday_color'],
    'inputType'			      => 'text',
    'exclude'			      => true,
    'eval'                    => array('maxlength'=>6, 'multiple'=>true, 'size'=>2, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bg_publicHoliday_color'] = array
(
    'label'				      => &$GLOBALS['TL_LANG']['tl_module']['bg_publicHoliday_color'],
    'inputType'			      => 'text',
    'exclude'			      => true,
    'eval'                    => array('maxlength'=>6, 'multiple'=>true, 'size'=>2, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['c_publicHoliday_color'] = array
(
    'label'				      => &$GLOBALS['TL_LANG']['tl_module']['c_publicHoliday_color'],
    'inputType'			      => 'text',
    'exclude'			      => true,
    'eval'                    => array('maxlength'=>6, 'multiple'=>true, 'size'=>2, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['progress_active'] = array
(
    'label'				      => &$GLOBALS['TL_LANG']['tl_module']['progress_active'],
    'inputType'			      => 'text',
    'exclude'			      => true,
    'eval'                    => array('maxlength'=>6,  'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['progress_future'] = array
(
    'label'				      => &$GLOBALS['TL_LANG']['tl_module']['progress_future'],
    'inputType'			      => 'text',
    'exclude'			      => true,
    'eval'                    => array('maxlength'=>6, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);