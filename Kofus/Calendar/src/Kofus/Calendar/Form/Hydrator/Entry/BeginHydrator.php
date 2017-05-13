<?php
namespace Kofus\Calendar\Form\Hydrator\Entry;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BeginHydrator implements HydratorInterface, ServiceLocatorAwareInterface
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
        $date1 = null;
        $array = $object->getDate1();
        if (isset($array[0])) {
            $date1 = new \DateTime();
            $array = $object->getDate1();
            $date1->setDate($array[0], $array[1], $array[2]);
        } 
        
        $time1 = null;
        $array = $object->getTime1();
        if ($array[0] !== null) {
            $timeSegments = array();
            foreach ($array as $index => $timeSegment) {
                if ($index > 0) {
                    $timeSegments[] = str_pad($timeSegment, 2, '0', STR_PAD_LEFT);
                } else {
                    $timeSegments[] = $timeSegment;
                }
            }
            
            $time1 = implode(':', $timeSegments);
        }
        
        $return = array(
            'date1' => null,
            'time1' => $time1,
        );
        if ($date1)
            $return['date1'] = $this->getIntlDateFormatterDate()->format($date1);
        return $return;
    }

    public function hydrate(array $data, $object)
    {
        $formatter = $this->getIntlDateFormatterDate();
        $sec = $formatter->parse($data['date1']);
        $dt = \DateTime::createFromFormat('U', $sec);
        
        $object->setDate1($dt->format('Y'), $dt->format('m'), $dt->format('d'));
        if ($data['time1']) {
            $array = explode(':', $data['time1']);
            $object->setTime1($array[0], $array[1]);
        } else {
            $object->setTime1(null, null);
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