<?php
namespace Kofus\Calendar\Form\Fieldset\Entry;

use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{

    public function init()
    {
        $this->setLabel('Ende');
        
        $el = new Element\Text('date2', array(
            'label' => 'Date'
        ));
        $el->setAttribute('class', 'datepicker');
        $el->setAttribute('data-language', \Locale::getPrimaryLanguage(\Locale::getDefault()));
        $el->setAttribute('autocomplete', 'off');
        $el->setOption('help-block', 'Nur bei Zeitspannen über mehrere Tage erforderlich');
        $this->add($el);
        
        $el = new Element\Time('time2', array(
            'label' => 'Time'
        ));
        $this->add($el);
        
    }

    public function getInputFilterSpecification()
    {
        return array(
            'date2' => array(
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'Zend\I18n\Validator\DateTime',
                        'options' => array(
                            'dateType' => \IntlDateFormatter::SHORT
                        )
                    )
                )
            ),
            
            'time2' => array(
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

