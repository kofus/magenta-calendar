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
    
    
}