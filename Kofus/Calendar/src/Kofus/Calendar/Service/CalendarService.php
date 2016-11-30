<?php
namespace Kofus\Calendar\Service;
use Kofus\System\Service\AbstractService;
use Kofus\Calendar\Entity\CalendarEntity;
use Kofus\Calendar\Container\Month;

class CalendarService extends AbstractService
{
    public function getMonth(CalendarEntity $calendar, $yearAndMonth)
    {
        $month = new Month($yearAndMonth);
        $month->setCalendar($calendar);
        return $month;
    }
}