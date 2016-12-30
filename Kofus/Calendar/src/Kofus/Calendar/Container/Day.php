<?php
namespace Kofus\Calendar\Container;
use Kofus\Calendar\Container\AbstractContainer;

class Day extends AbstractContainer
{
    public function __construct($date)
    {
        $this->dateTimeStart = \DateTime::createFromFormat('Y-m-d', $date);
    }
    
    public function isHoliday()
    {
        if ($this->getDateTimeStart()->format('w') == 0)
            return true;
        return false;
    }
    
    public function getHolidays()
    {
        $today = $this->getDateTimeStart()->format('Y-m-d');
        $holidays = array();
        foreach ($this->holidayLists as $listId => $data) {
            foreach ($data['entries'] as $date => $label) {
                if ($date == $today) {
                    $holidays[] = array(
                    	'label' => $label,
                        'list' => $data['label'],
                        'list_id' => $listId
                    );
                }
            }
        }
        return $holidays;
    }
    
    
}