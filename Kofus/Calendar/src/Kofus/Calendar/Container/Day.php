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
        $dt = $this->getDateTimeStart();
        $today = $dt->format('Y-m-d');
        $holidays = array();
        foreach ($this->holidayLists as $listId => $data) {
            foreach ($data['entries'] as $date => $label) {
                if ($date == $today) {
                    $holidays[] = array(
                    	'label' => $label,
                        'list' => $data['label'],
                        'list_id' => $listId,
                        'type' => $data['type']
                    );
                } elseif (isset($label['from']) && isset($label['to'])) {
                    $from = \DateTime::createFromFormat('Y-m-d', $label['from']);
                    $to = \DateTime::createFromFormat('Y-m-d', $label['to']);
                    if ($from <= $dt && $dt <= $to) {
                        $holidays[] = array(
                            'label' => $label['label'],
                            'list' => $data['label'],
                            'list_id' => $listId,
                            'type' => $data['type'],
                            'color' => $data['color']
                        );
                    }
                }
            }
        }
        return $holidays;
    }
    
    
}