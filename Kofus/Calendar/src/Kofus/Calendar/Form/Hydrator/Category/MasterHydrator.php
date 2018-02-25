<?php
namespace Kofus\Calendar\Form\Hydrator\Category;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MasterHydrator implements HydratorInterface
{
    public function extract($object)
    {
        return array(
            'title' => $object->getTitle(),
            'bg_color' => $object->getBackgroundColor(),
            'color' => $object->getColor(),
            'priority' => $object->getPriority()
        );
    }

    public function hydrate(array $data, $object)
    {
        $object->setTitle($data['title']);
        $object->setBackgroundColor($data['bg_color']);
        $object->setColor($data['color']);
        $object->setPriority($data['priority']);
        return $object;
    }
    
    
}