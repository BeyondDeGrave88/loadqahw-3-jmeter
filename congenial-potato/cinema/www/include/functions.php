<?php
    function getWeekDayRus($add =0){
        $days = array(
            'Вс', 'Пн', 'Вт', 'Ср',
            'Чт', 'Пт', 'Сб'
        );

        $date = date_create('now 00:00:00', new DateTimeZone('Europe/Moscow'));
        $date->modify("+$add day");

        $myDayWeek = $date->format('w');
        $weekEnd = (($myDayWeek == 0) || ($myDayWeek == 6)) ? 'page-nav__day_weekend' : '';
        $timeStamp = $date->getTimeStamp();

        $result =  array('day' => $date->format('j'),
                    'dayWeek' => $days[$myDayWeek],
                    'weekEnd' => $weekEnd,
                    'timeStamp' => $timeStamp);
        return $result;
    }


?>