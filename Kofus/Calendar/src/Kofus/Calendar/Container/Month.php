<?php
namespace Kofus\Calendar\Container;

use Kofus\Calendar\Container\AbstractContainer;
use Kofus\Calendar\Container\Week;

class Month extends AbstractContainer
{
    public function __construct($yearAndMonth)
    {
        $this->dateTimeStart = \DateTime::createFromFormat('Y-m-d', $yearAndMonth . '-01');
    }
    
    
    public function getWeekNumbers()
    {
        $weekNumbers = array();
        $dt = \DateTime::createFromFormat('Y-m-d', $this->getDateTimeStart()->format('Y-m') . '-01');
        $month = $dt->format('m');
        $lastWeekNumber = null;
        
        while ($dt->format('m') == $month) {
            $weekNumber = $dt->format('W');
            if ($weekNumber != $lastWeekNumber) {
                if ($month == 1 && $weekNumber > 40) {
                    $weekNumbers[] = array($weekNumber, $dt->format('Y') - 1);
                } else {
                    $weekNumbers[] = array($weekNumber, $dt->format('Y'));
                }
            } 
            $dt->modify('+1 day');
            $lastWeekNumber = $weekNumber;
        }
        return $weekNumbers;
    }
    
    public function getWeeks()
    {
        $weeks = array();
        $year = $this->getDateTimeStart()->format('Y');
        foreach ($this->getWeekNumbers() as $delta) {
            $week = new Week($delta[0], $delta[1]);
            $week->setCalendar($this->getCalendar());
            $week->setEntries($this->getEntries());
            $week->setHolidayLists($this->getHolidayLists());
            $weeks[] = $week;
        }
        return $weeks;
    }
    
    
}