<?php
namespace Kofus\Calendar\Form\Hydrator\Entry;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContentHydrator implements HydratorInterface, ServiceLocatorAwareInterface
{
    public function extract($object)
    {
        $calendarId = null;
        if ($object->getCalendar())
            $calendarId = $object->getCalendar()->getNodeId();
        
        $categoryIds = array();
        foreach ($object->getCategories() as $category)
            $categoryIds[$category->getNodeId()] = $category->getNodeId();
        
        $return = array(
            'title' => $object->getTitle(),
            'enabled' => $object->isEnabled(),
            'content' => $object->getContent(),
            'calendar' => $calendarId,
            'categories' => $categoryIds
        );
        
        return $return;
    }

    public function hydrate(array $data, $object)
    {
        $categories = array();
        if ($data['categories']) {
            foreach ($data['categories'] as $categoryId) {
                $category = $this->nodes()->getNode($categoryId, 'CALCAT');
                $categories[] = $category;
            }
        }
        
        
        $object->setTitle($data['title']);
        $object->isEnabled($data['enabled']);
        $object->setContent($data['content']);
        $object->setCategories($categories);
        
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
    
    protected function nodes()
    {
        return $this->getServiceLocator()->get('KofusNodeService');
    }
}