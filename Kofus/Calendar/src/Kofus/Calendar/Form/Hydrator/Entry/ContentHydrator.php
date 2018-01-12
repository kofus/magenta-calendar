<?php
namespace Kofus\Calendar\Form\Hydrator\Entry;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContentHydrator implements HydratorInterface, ServiceLocatorAwareInterface
{
    protected function getIntlDateFormatterDate()
    {
        return new \IntlDateFormatter(
            \Locale::getDefault(), 
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::NONE,
            'UTC'
        );
    }
    
    protected function getIntlDateFormatterTime()
    {
    	return new \IntlDateFormatter(
    			\Locale::getDefault(),
    			\IntlDateFormatter::NONE,
    			\IntlDateFormatter::SHORT,
    			'UTC'
    	);
    }

    public function extract($object)
    {
        $calendarId = null;
        if ($object->getCalendar())
            $calendarId = $object->getCalendar()->getNodeId();
        
        $return = array(
            'title' => $object->getTitle(),
            'enabled' => $object->isEnabled(),
            'content' => $object->getContent(),
            'calendar' => $calendarId
        );
        
        return $return;
    }

    public function hydrate(array $data, $object)
    {
        $object->setTitle($data['title']);
        $object->isEnabled($data['enabled']);
        $object->setContent($data['content']);
        
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