<?php
namespace Kofus\Calendar\Form\Hydrator\DateOfBirth;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MasterHydrator implements HydratorInterface, ServiceLocatorAwareInterface
{
   

    public function extract($object)
    {
        $calendarId = null;
        if ($object->getCalendar())
            $calendarId = $object->getCalendar()->getNodeId();
        
        $date = $object->getDate1();
        
        return array(
            'day' => $date[2],
            'month' => $date[1],
            'year' => $date[0],
            'title' => $object->getTitle(),
            'enabled' => $object->isEnabled(),
            'calendar' => $calendarId
        );
    }

    public function hydrate(array $data, $object)
    {
        $object->setTitle($data['title']);
        $object->isEnabled($data['enabled']);
        $object->setDate1($data['year'], $data['month'], $data['day']);
        $calendar = $this->getServiceLocator()->get('KofusNodeService')->getNode($data['calendar'], 'CAL');
        $object->setCalendar($calendar);
        
        
        return $object;
    }
    
    protected $sm;
    
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
    	$this->sm = $serviceLocator;
    }
    
    public function getServiceLocator()
    {
    	return $this->sm;
    }    
}