<?php
namespace Kofus\Calendar\Container;
use Kofus\Calendar\Container\AbstractContainer;

class Day extends AbstractContainer
{
    public function __construct($date)
    {
        $this->dateTimeStart = \DateTime::createFromFormat('Y-m-d', $date);
    }
    
    
}