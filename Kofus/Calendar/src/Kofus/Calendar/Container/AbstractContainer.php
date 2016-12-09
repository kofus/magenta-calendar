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
    
    protected $entries = array();
    
    public function setEntries(array $entries)
    {
        $this->entries = $entries; return $this;
    }
    
    public function getEntries($filterKey=null, $filterValue=null)
    {
        switch ($filterKey) {
        	case 'day':
        	    $entries = array();
        	    foreach ($this->entries as $entry) {
        	        $dateArray = $entry->getDate1();
        	        if ($dateArray != $filterValue)
        	            continue;
        	        $entries[] = $entry;
        	    }
        	    return $entries;
        	    break;
        	default:
        	    return $this->entries;
        }
    }
    
    
}