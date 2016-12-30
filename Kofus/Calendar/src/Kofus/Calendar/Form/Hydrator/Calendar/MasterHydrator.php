<?php
namespace Kofus\Calendar\Form\Hydrator\Calendar;

use Zend\Stdlib\Hydrator\HydratorInterface;

class MasterHydrator implements HydratorInterface
{

    public function extract($object)
    {
        return array(
            'title' => $object->getTitle(),
            'enabled' => $object->isEnabled(),
            'holidays' => $object->getHolidayListIds()
        );
    }

    public function hydrate(array $data, $object)
    {
        $holidays = array();
        if (isset($data['holidays']))
            $holidays = $data['holidays'];
        $object->setTitle($data['title']);
        $object->isEnabled($data['enabled']);
        $object->setHolidayListIds($holidays);
        return $object;
    }
}