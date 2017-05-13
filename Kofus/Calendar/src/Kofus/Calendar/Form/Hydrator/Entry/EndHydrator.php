<?php
namespace Kofus\Calendar\Form\Hydrator\Entry;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndHydrator implements HydratorInterface, ServiceLocatorAwareInterface
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
        $date2 = null;
        $array = $object->getDate2();
        if (isset($array[0])) {
            $date2 = new \DateTime();
            $array = $object->getDate2();
            $date2->setDate($array[0], $array[1], $array[2]);
        } 
        
        $time2 = null;
        $array = $object->getTime2();
        if ($array[0] !== null) {
            $timeSegments = array();
            foreach ($array as $index => $timeSegment) {
                if ($index > 0) {
                    $timeSegments[] = str_pad($timeSegment, 2, '0', STR_PAD_LEFT);
                } else {
                    $timeSegments[] = $timeSegment;
                }
            }
            
            $time2 = implode(':', $timeSegments);
        }
        
        $return = array(
            'date2' => null,
            'time2' => $time2,
        );
        if ($date2)
            $return['date2'] = $this->getIntlDateFormatterDate()->format($date2);
        return $return;
    }

    public function hydrate(array $data, $object)
    {
        $formatter = $this->getIntlDateFormatterDate();
        $sec = $formatter->parse($data['date2']);
        $dt = \DateTime::createFromFormat('U', $sec);
        
        $object->setDate2($dt->format('Y'), $dt->format('m'), $dt->format('d'));
        if ($data['time2']) {
            $array = explode(':', $data['time2']);
            $object->setTime2($array[0], $array[1]);
        } else {
            $object->setTime2(null, null);
        }
        
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