<?php
namespace Kofus\Calendar\Container;

use Kofus\Calendar\Container\AbstractContainer;
use Kofus\Calendar\Container\Day;

class Week extends AbstractContainer
{
    protected $number;
    protected $year;
    
    public function __construct($number, $year)
    {
        $this->number = $number;
        $this->year = $year;
    }
    
    public function getDateTimeStart()
    {
        if (! $this->dateTimeStart) {
            $this->dateTimeStart = new \DateTime();
            $this->dateTimeStart->setISODate($this->year, $this->number);
        }
        return $this->dateTimeStart;
    }
    
    public function getDateTimeEnd()
    {
        if (! $this->dateTimeEnd) {
            $this->dateTimeEnd = $this->getDateTimeStart();
            $this->dateTimeEnd->modify('+6 days');
        }
        return $this->dateTimeEnd;
    }
    
    public function getDays()
    {
        $dt = $this->getDateTimeStart();
        $days = array();
        
        for ($i = 0; $i < 7; $i += 1) {
            $day = new Day($dt->format('Y-m-d'));
            $day->setHolidayLists($this->getHolidayLists());
            $day->setCalendar($this->getCalendar());
            $day->setEntries($this->getEntries('day', array($dt->format('Y'), $dt->format('m'), $dt->format('d'))));
            $days[] = $day;
            $dt->modify('+1 day');
        }
        return $days;
    }
    
    
    
}