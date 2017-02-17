<?php
namespace Kofus\Calendar\Form\Fieldset\DateOfBirth;

use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MasterFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{

    public function init()
    {
        $el = new Element\Text('title', array(
            'label' => 'Name'
        ));
        $this->add($el);
        
        $days = array_combine(range(1, 31), range(1, 31));
        $el = new Element\Select('day', array(
            'label' => 'Day'
        ));
        $el->setValueOptions($days);
        $this->add($el);
        
        $months = array(
        	1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        );
        $el = new Element\Select('month', array(
            'label' => 'Month'
        ));
        $el->setValueOptions($months);
        $this->add($el);
        
        $years = range(date('Y'), 1900);
        $el = new Element\Select('year', array(
            'label' => 'Year'
        ));
        $el->setValueOptions(array_combine($years, $years));
        $el->setEmptyOption('');
        $this->add($el);
        
        $el = new Element\Select('calendar', array(
            'label' => 'Calendar'
        ));
        $valueOptions = array();
        foreach ($this->getServiceLocator()
            ->get('KofusNodeService')
            ->getRepository('CAL')
            ->findAll() as $calendar)
            $valueOptions[$calendar->getNodeId()] = $calendar->getTitle();
        $el->setValueOptions($valueOptions);
        $this->add($el);
        
        $el = new Element\Checkbox('enabled', array(
            'label' => 'enabled?'
        ));
        $this->add($el);
    }

    public function getInputFilterSpecification()
    {
        return array(
            
            'title' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'Zend\Filter\StringTrim'
                    )
                )
            ),
            'day' => array(
                'required' => true
            ),
            'month' => array(
                'required' => true
            ),
            'year' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'Zend\Filter\ToNull'
                    )
                )
            ),
            'calendar' => array(
                'required' => true
            )
        )
        ;
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

