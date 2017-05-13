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
        	        
        	        $dateTime1 = $entry->getDateTime1();
        	        $dateTime2 = $entry->getDateTime2();
        	        
        	        // Birth dates
        	        if ($entry->getNodeType() == 'CALENTB') {
        	            $date1 = $entry->getDate1();
        	            $sDate1 = $filterValue[0] . '-' . str_pad($date1[1], 2, '0', STR_PAD_LEFT) . '-' . str_pad($date1[2], 2, '0', STR_PAD_LEFT);
        	            $sFilterValue = implode('-', $filterValue);
        	            if ($sDate1 == $sFilterValue)
        	                $entries[] = $entry;
        	            continue;
        	        }
        	        
        	        $dateTimeFilter = \DateTime::createFromFormat('Y-m-d', implode('-', $filterValue));
        	        
        	        // Dates with an end time
        	        if ($dateTime2) {
        	            if ($dateTime1->format('Y-m-d') <= $dateTimeFilter->format('Y-m-d') && $dateTime2->format('Y-m-d') >= $dateTimeFilter->format('Y-m-d'))
        	            	$entries[] = $entry;
        	            continue;
        	        }

        	        // Exact match?
       	            if ($dateTime1->format('Y-m-d') == $dateTimeFilter->format('Y-m-d'))
       	                $entries[] = $entry;
        	    }
        	    return $entries;
        	    break;
        	default:
        	    return $this->entries;
        }
    }
    
    protected $holidayLists = array();
    
    public function addHolidayList($id, array $data)
    {
        $this->holidayLists[$id] = $data; return $this;
    }
    
    public function setHolidayLists(array $lists)
    {
        $this->holidayLists = $lists; return $this;
    }
    
    public function getHolidayLists()
    {
        return $this->holidayLists;
    }
    
 
    
}