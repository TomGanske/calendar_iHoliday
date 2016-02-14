<?php

/**
 * Contao Extension iHoliday
 * Copyright (c) 2015-2016 Tom Ganske
 * author     Tom Ganske (http://ct-eye.com ||  https://github.com/TomGanske)
 * @license   LGPL-3.0+
 */

namespace Contao;

class CalendarImportExt extends \CalendarImport
{
    public function importExt()
    {
        $this->loadLanguageFile("tl_calendar_events");
        $this->Template = new BackendTemplate('be_importExt_calendar');


        $this->Template->headline   = 'Test';
        $this->Template->message    = \Message::generate();
        $this->Template->event_type = $this->getEventTypeWidget();
        $this->Template->hrefBack   = ampersand(str_replace('&key=import', '', \Environment::get('request')));
        $this->Template->goBack     = $GLOBALS['TL_LANG']['MSC']['goBack'];
        $this->Template->headline   = $GLOBALS['TL_LANG']['MSC']['import_calendar'][0];
        $this->Template->request    = ampersand(\Environment::get('request'), ENCODE_AMPERSANDS);
        $this->Template->submit     = specialchars($GLOBALS['TL_LANG']['tl_calendar_events']['importExt'][0]);

        if (\Input::post('FORM_SUBMIT') == 'tl_importExt_calendar'){
            if(empty(\Input::post('event_type'))){
                \Message::addError($GLOBALS['TL_LANG']['ERR']['all_fields']);
                $this->reload();
            }
            else {
                $this->Session->set('event_type', \Input::post('event_type'));
                $this->redirect(str_replace('&key=importExt', '&key=import', \Environment::get('request')));
            }
        }


        return $this->Template->parse();

    }



    /**
     * Return the select field widget as object
     * @param mixed
     * @return object
     */
    protected function getEventTypeWidget($value=null)
    {
        $widget = new SelectMenu();

        $widget->id = 'event_type';
        $widget->name = 'event_type';
        $widget->mandatory = false;
        $widget->options = array(
            array(
                'value' => '0',
                'label' => $GLOBALS['TL_LANG']['tl_calendar_events']['event_type']['label'][0]),
            array(
                'value' => '1',
                'label' => $GLOBALS['TL_LANG']['tl_calendar_events']['event_type']['label'][1]),
            array(
                'value' => '2',
                'label' => $GLOBALS['TL_LANG']['tl_calendar_events']['event_type']['label'][2]),
            array(
                'value' => '3',
                'label' => $GLOBALS['TL_LANG']['tl_calendar_events']['event_type']['label'][3]),
            array(
                'value' => '4',
                'label' => $GLOBALS['TL_LANG']['tl_calendar_events']['event_type']['label'][4])
        );

        $widget->value = $value;
        $widget->label = $GLOBALS['TL_LANG']['tl_calendar_events']['event_type'][0];

        if ($GLOBALS['TL_CONFIG']['showHelp'] && strlen($GLOBALS['TL_LANG']['tl_calendar_events']['event_type'][1]))
        {
            $widget->help = $GLOBALS['TL_LANG']['tl_calendar_events']['event_type'][1];
        }

        // Valiate input
        if (\Input::post('FORM_SUBMIT') == 'tl_importExt_calendar')
        {
            $widget->validate();

            if ($widget->hasErrors())
            {
                $this->blnSave = false;
            }
        }

        return $widget;
    }
}