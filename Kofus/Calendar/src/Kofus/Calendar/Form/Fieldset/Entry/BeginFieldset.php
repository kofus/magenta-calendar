<?php
namespace Kofus\Calendar\Form\Fieldset\Entry;

use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BeginFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{

    public function init()
    {
        $this->setLabel('Beginn');
        
        $el = new Element\Text('date1', array(
            'label' => 'Date'
        ));
        $el->setAttribute('class', 'datepicker');
        $el->setAttribute('data-language', \Locale::getPrimaryLanguage(\Locale::getDefault()));
        $el->setAttribute('autocomplete', 'off');
        $this->add($el);
        
        $el = new Element\Time('time1', array(
            'label' => 'Time'
        ));
        $this->add($el);
    }

    public function getInputFilterSpecification()
    {
        return array(
            'date1' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'Zend\I18n\Validator\DateTime',
                        'options' => array(
                            'dateType' => \IntlDateFormatter::SHORT
                        )
                    )
                )
            ),
            
            'time1' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'Zend\Filter\StringTrim'
                    ),
                    array(
                        'name' => 'Zend\Filter\ToNull'
                    )
                )
                
            )
        );
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

