<?php

namespace Kofus\Calendar\View\Helper;
use Zend\View\Helper\AbstractHelper;

class CalendarEntryTimeHelper extends AbstractHelper
{
    public function __invoke($time, $suffix=null)
    {
        $s = '';
        if (is_array($time) && count($time) > 1) {
            $s .= str_pad($time[0], 2, '0', STR_PAD_LEFT);
            $s .= ':';
            $s .= str_pad($time[1], 2, '0', STR_PAD_LEFT);
            if ($suffix)
                $s .= ' ' . $suffix;
        }
        return $s;
    }
    

}