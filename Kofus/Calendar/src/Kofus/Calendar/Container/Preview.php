<?php
namespace Kofus\Calendar\Container;

use Kofus\Calendar\Container\AbstractContainer;
use Kofus\Calendar\Container\Day;

class Preview extends AbstractContainer
{
    protected $number;
    protected $year;
    
  
    public function __construct($date)
    {
    	$this->dateTimeStart = \DateTime::createFromFormat('Y-m-d', $date);
    	$this->dateTimeStart->modify('-1 day');
    }


    
    public function getDateTimeStart()
    {
        return $this->dateTimeStart;
    }
    
    public function getDateTimeEnd()
    {
        if (! $this->dateTimeEnd) {
            $this->dateTimeEnd = \DateTime::createFromFormat('Y-m-d', $this->getDateTimeStart()->format('Y-m-d'));
            $this->dateTimeEnd->modify('+6 days');
        }
        return $this->dateTimeEnd;
    }
    
    protected $days = array();
    
    public function getDays()
    {
        if (! $this->days) {
            $date = $this->getDateTimeStart()->format('Y-m-d');
            $tmp = \DateTime::createFromFormat('Y-m-d', $date);
    
            for ($i = 0; $i < 7; $i += 1) {
                $day = new Day($tmp->format('Y-m-d'));
                $day->setHolidayLists($this->getHolidayLists());
                $day->setCalendar($this->getCalendar());
                $day->setEntries($this->getEntries('day', array($tmp->format('Y'), $tmp->format('m'), $tmp->format('d'))));
                $this->days[] = $day;
                $tmp->modify('+1 day');
            }
        }
        

        return $this->days;
    }
    
    
    
}