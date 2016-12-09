<?php
namespace Kofus\Calendar\Form\Hydrator\Entry;

use Zend\Stdlib\Hydrator\HydratorInterface;

class MasterHydrator implements HydratorInterface
{
    protected function getIntlDateFormatter()
    {
        return new \IntlDateFormatter(
            \Locale::getDefault(), 
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::NONE,
            'UTC'
        );
    }

    public function extract($object)
    {
        $formatter = $this->getIntlDateFormatter();
        $dt = $object->getDateTime1();
        if (! $dt) $dt = new \DateTime(); 

        return array(
            'date1' => $formatter->format($dt),
            'title' => $object->getTitle(),
            'enabled' => $object->isEnabled()
        );
    }

    public function hydrate(array $data, $object)
    {
        $formatter = $this->getIntlDateFormatter();
        $sec = $formatter->parse($data['date1']);
        $dt = \DateTime::createFromFormat('U', $sec);
        
        $object->setTitle($data['title']);
        $object->isEnabled($data['enabled']);
        $object->setDate1($dt->format('Y'), $dt->format('m'), $dt->format('d'));
        
        return $object;
    }
}