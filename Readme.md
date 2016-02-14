#calendar_iHoliday for Contao#

--

- Version: 1.1 (update :: Feb 2016)


**Information**
>
iHoliday **Calender extension** is for the **Contao CMS in Version 3.5.4 - 6**. A simple solution to manage your holidays, events and vacation times colorful.
Customize your legend by selecting your favorite colors as well simply use a 12 month preview calendar template which comes already with.
 
**Demo** 
> [Demo calendar_iHoliday](http://www.ct-eye.com/calendar_iholiday.html)
 

**Notice**
> The Extension comes only with .html5 template files. If you need .xhtml files create that by your self.

> **Thanks!**

##Requirements##
* Contao Extension
* Extension Calendar
* Extension Calendar_ical (modified) by one line :)
* Extension ical_creator
* Bootstrap Framework (for template design)

###Instruction to get it work###
>
The **body** Tag of your website should extended by the attribute **ontouchstart=""**.

###Modify Calendar_ical###
Open the file below and paste the follow code line into the line 760 of your file.
> system/modules/calendar_ical/classes/CalendarImport.php
* line 760 : $arrFields['event_type'] = $this->Session->get('event_type');


*I think thats it. Enjoy it and let me know...*



> *Tom Ganske*

> [CT-EYE®](http://www.ct-eye.com)
