<?php
namespace Kofus\Calendar\Container;

use Kofus\Calendar\Entity\CalendarEntity;

abstract class AbstractContainer
{
    protected $calendar;
    
    public function setCalendar(CalendarEntity $calendar)
    {
    	$this->calendar = $calendar; return $this;
    }
    
    public function getCalendar()
    {
    	return $this->calendar;
    }
    
    protected $dateTimeStart;
    
    public function setDateTimeStart(\DateTime $dateTime)
    {
    	$this->dateTimeStart = $dateTime; return $this;
    }
    
    public function getDateTimeStart()
    {
    	return $this->dateTimeStart;
    }

    protected $dateTimeEnd;
    
    public function setDateTimeEnd(\DateTime $dateTime)
    {
    	$this->dateTimeEnd = $dateTime; return $this;
    }
    
    public function getDateTimeEnd()
    {
    	return $this->dateTimeEnd;
    }
    
    
}