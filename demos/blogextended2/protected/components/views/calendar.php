<center>
<ul class="Calendar">
<?php
   // @version $Id: calendar.php 14 2010-01-12 04:08:29Z mocapapa@g.pugpug.org $
   if (isset(Yii::app()->params['calendarLocale']) && Yii::app()->params['calendarLocale'] == 'Japan')
     include_once('generate_calendar_Japan.php');
   else
     include_once('generate_calendar.php');
echo generate_calendar($year, $month, $days, $len, $url, 0, $pnc);
?>
</ul>
</center>
