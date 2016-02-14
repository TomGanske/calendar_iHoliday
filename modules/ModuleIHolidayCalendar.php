<?php

/**
 * Contao Extension iHoliday
 * Copyright (c) 2015-2016 Tom Ganske
 * author     Tom Ganske (http://ct-eye.com ||  https://github.com/TomGanske)
 * @license   LGPL-3.0+
 * Notice:    Some code lines are originally by Leo Feyer!
 */

namespace Contao;

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Calendar
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */



/**
 * Class ModuleIHolidayCalendar
 *
 * @copyright  Leo Feyer, modified by Tom Ganske 2015
 * @author     Tom Ganske
 * @package    calendar_iHoliday
 */
class ModuleIHolidayCalendar extends \Events
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_calendarYear';


    /**
     * Do not show the module if no calendar has been selected
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            /** @var \BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['calendar_iHoliday'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $this->cal_calendar = $this->sortOutProtected(deserialize($this->cal_calendar, true));

        // Return if there are no calendars
        if (!is_array($this->cal_calendar) || empty($this->cal_calendar))
        {
            return '';
        }

        $this->strUrl = preg_replace('/\?.*$/', '', \Environment::get('request'));
        $this->strLink = $this->strUrl;

        if ($this->jumpTo && ($objTarget = $this->objModel->getRelated('jumpTo')) !== null)
        {
            $this->strLink = $this->generateFrontendUrl($objTarget->row());
        }

        return parent::generate();
    }


    /**
	 * Generate the module
	 */
	protected function compile()
    {
        $calendar = '';

        // set year
        if( !empty($this->start_year) && empty(\Input::get('year')))
            $year = $this->start_year;
        elseif(empty($this->start_year) && empty(\Input::get('year')))
            $year = date("Y");
        else
            $year = \Input::get('year');



        for ($i = $this->start_show_month; $i <= $this->end_show_month; $i++)
        {
            $this->Date = new \Date($year.$i, 'Ym');

            /** @var \FrontendTemplate|object $objTemplate */
            $objTemplate = new \FrontendTemplate(($this->cal_ctemplate ? $this->cal_ctemplate : 'cal_single'));

            // Current month and year
            $objTemplate->current = $GLOBALS['TL_LANG']['MONTHS'][$i -1] . ' ' . date('Y', $this->Date->tstamp);

            // Set the week start day
            if (!$this->cal_startDay) {
                $this->cal_startDay = 0;
            }

            $objTemplate->days = $this->compileDays();
            $objTemplate->weeks = $this->compileWeeks($this->Date);


            $objTemplate->substr = $GLOBALS['TL_LANG']['MSC']['dayShortLength'];

            $calendar .= $objTemplate->parse();
        }

        // set Template vars
        $this->Template->calendars              = $calendar;
        $this->Template->bg_holiday_color       = '#'.deserialize($this->bg_holiday_color,true)[0];
        $this->Template->bg_event_color         = '#'.deserialize($this->bg_event_color,true)[0];
        $this->Template->bg_closing_color       = '#'.deserialize($this->bg_closing_color,true)[0];
        $this->Template->bg_publicHoliday_color = '#'.deserialize($this->bg_publicHoliday_color,true)[0];

        $this->Template->c_holiday_color        = '#'.deserialize($this->c_holiday_color,true)[0];
        $this->Template->c_publicHoliday_color  = '#'.deserialize($this->c_publicHoliday_color,true)[0];
        $this->Template->c_event_color          = '#'.deserialize($this->c_event_color,true)[0];
        $this->Template->c_closing_color        = '#'.deserialize($this->c_closing_color,true)[0];



        $this->Template->next_year          = $year + 1;
        $this->Template->prev_year          = $year - 1;
        $this->Template->url                = (strpos(\Environment::get('requestUri'),'year') !== false) ? substr(\Environment::get('requestUri'),0,strpos(\Environment::get('requestUri'),'year')-1) : \Environment::get('requestUri') ;
	}


    /**
     * Return the week days and labels as array
     *
     * @return array
     */
    protected function compileDays()
    {
        $arrDays = array();

        for ($i=0; $i<7; $i++)
        {
            $strClass = '';
            $intCurrentDay = ($i + $this->cal_startDay) % 7;

            if ($i == 0)
            {
                $strClass .= ' col_first';
            }
            elseif ($i == 6)
            {
                $strClass .= ' col_last';
            }

            if ($intCurrentDay == 0 || $intCurrentDay == 6)
            {
                $strClass .= ' weekend';
            }

            $arrDays[$intCurrentDay] = array
            (
                'class' => $strClass,
                'name' => $GLOBALS['TL_LANG']['DAYS'][$intCurrentDay]
            );
        }

        return $arrDays;
    }


    /**
     * Return the weeks of the current month as array
     * @param Date date
     * @return array
     */
    protected function compileWeeks($date)
    {
        $intDaysInMonth = date('t', $date->monthBegin);
        $intFirstDayOffset = date('w', $date->monthBegin) - $this->cal_startDay;

        if ($intFirstDayOffset < 0)
        {
            $intFirstDayOffset += 7;
        }

        $intColumnCount     = -1;
        $intNumberOfRows    = ceil(($intDaysInMonth + $intFirstDayOffset) / 7);
        $arrAllEvents       = $this->getAllEvents($this->cal_calendar, $date->monthBegin, $date->monthEnd);

        $arrDays            = array();

        // Compile days
        for ($i=1; $i<=($intNumberOfRows * 7); $i++)
        {
            $intWeek = floor(++$intColumnCount / 7);
            $intDay = $i - $intFirstDayOffset;
            $intCurrentDay = ($i + $this->cal_startDay) % 7;

            $strWeekClass = 'week_' . $intWeek;
            $strWeekClass .= ($intWeek == 0) ? ' first' : '';
            $strWeekClass .= ($intWeek == ($intNumberOfRows - 1)) ? ' last' : '';

            $strClass = ($intCurrentDay < 2) ? ' weekend' : '';
            $strClass .= ($i == 1 || $i == 8 || $i == 15 || $i == 22 || $i == 29 || $i == 36) ? ' col_first' : '';
            $strClass .= ($i == 7 || $i == 14 || $i == 21 || $i == 28 || $i == 35 || $i == 42) ? ' col_last' : '';

            // Empty cell
            if ($intDay < 1 || $intDay > $intDaysInMonth)
            {
                $arrDays[$strWeekClass][$i]['label'] = '&nbsp;';
                $arrDays[$strWeekClass][$i]['class'] = 'days empty' . $strClass ;
                $arrDays[$strWeekClass][$i]['events'] = array();

                continue;
            }

            $intKey = date('Ym', $this->Date->tstamp) . ((strlen($intDay) < 2) ? '0' . $intDay : $intDay);
            $strClass .= ($intKey == date('Ymd')) ? ' today' : '';

            // Mark the selected day (see #1784)
            if ($intKey == \Input::get('day'))
            {
                $strClass .= ' selected';
            }

            // Inactive days
            if (empty($intKey) || !isset($arrAllEvents[$intKey]))
            {
                $arrDays[$strWeekClass][$i]['label'] = $intDay;
                $arrDays[$strWeekClass][$i]['class'] = 'days' . $strClass;
                $arrDays[$strWeekClass][$i]['events'] = array();

                continue;
            }

            $arrEvents = array();
            $arrEventColor = array();

            // Get all events of a day
            foreach ($arrAllEvents[$intKey] as $v)
            {
                foreach ($v as $vv)
                {
                    // set Colors for Background and Font
                    // 4 = Feiertage (publicHolidays)
                    // 3 = Ferien (holidays)
                    // 2 = Termine (events)
                    // 1 = Schließzeiten (closingTime)

                    // nur dieses Ereignis, keine anderes überschreibt dieses
                    if($vv['event_type']==3){
                        if(!empty($arrEventColor['bg_color'])){
                            $arrEventColor['bg_color_secondar']     = $arrEventColor['bg_color'];
                            $arrEventColor['font_color_secondar']   = $arrEventColor['font_color'];
                            $arrEventColor['bg_color']              = '#' . deserialize($this->bg_holiday_color, true)[0];
                            $arrEventColor['font_color']            = '#' . deserialize($this->c_holiday_color, true)[0];
                        }else {
                            $arrEventColor['bg_color']              = '#' . deserialize($this->bg_holiday_color, true)[0];
                            $arrEventColor['font_color']            = '#' . deserialize($this->c_holiday_color, true)[0];
                        }
                    }
                    elseif($vv['event_type']==4){
                        if(!empty($arrEventColor['bg_color'])) {
                            $arrEventColor['bg_color_secondar']     = '#' . deserialize($this->bg_publicHoliday_color, true)[0];
                            $arrEventColor['font_color_secondar']   = '#' . deserialize($this->c_publicHoliday_color, true)[0];
                        } else {
                            $arrEventColor['bg_color']              = '#' . deserialize($this->bg_publicHoliday_color, true)[0];
                            $arrEventColor['font_color']            = '#' . deserialize($this->c_publicHoliday_color, true)[0];
                        }
                    }
                    elseif($vv['event_type']==2){

                        if(!empty($arrEventColor['bg_color'])){
                            $arrEventColor['bg_color_secondar']     = '#'.deserialize($this->bg_event_color,true)[0];
                            $arrEventColor['font_color_secondar']   = '#'.deserialize($this->c_event_color,true)[0];
                        }else {
                            $arrEventColor['bg_color']              = '#'.deserialize($this->bg_event_color,true)[0];
                            $arrEventColor['font_color']            = '#'.deserialize($this->c_event_color,true)[0];
                        }

                    }
                    elseif($vv['event_type']==1){
                        if(!empty($arrEventColor['bg_color'])){
                            $arrEventColor['bg_color_secondar']     = '#' . deserialize($this->bg_closing_color, true)[0];
                            $arrEventColor['font_color_secondar']   = '#' . deserialize($this->c_closing_color, true)[0];
                        }
                        else {
                            $arrEventColor['bg_color']              = '#' . deserialize($this->bg_closing_color, true)[0];
                            $arrEventColor['font_color']            = '#' . deserialize($this->c_closing_color, true)[0];
                        }
                    }

                    $arrEvents[] = $vv;
                }
            }

            $arrDays[$strWeekClass][$i]['label']                = $intDay;
            $arrDays[$strWeekClass][$i]['class']                = 'days active' . $strClass;
            $arrDays[$strWeekClass][$i]['href']                 = $this->strLink . (\Config::get('disableAlias') ? '&amp;' : '?') . 'day=' . $intKey;
            $arrDays[$strWeekClass][$i]['title']                = sprintf(specialchars($GLOBALS['TL_LANG']['MSC']['cal_events']), count($arrEvents));
            $arrDays[$strWeekClass][$i]['events']               = $arrEvents;
            $arrDays[$strWeekClass][$i]['bg_color']             = $arrEventColor['bg_color'];
            $arrDays[$strWeekClass][$i]['font_color']           = $arrEventColor['font_color'];
            $arrDays[$strWeekClass][$i]['bg_color_secondar']    = $arrEventColor['bg_color_secondar'];
            $arrDays[$strWeekClass][$i]['font_color_secondar']  = $arrEventColor['font_color_secondar'];
            #$arrEventColor = array();
        }

        return $arrDays;
    }
}
