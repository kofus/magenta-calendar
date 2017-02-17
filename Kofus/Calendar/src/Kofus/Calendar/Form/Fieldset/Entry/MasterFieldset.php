<?php
namespace Kofus\Calendar\Form\Fieldset\Entry;

use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MasterFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{

    public function init()
    {
        $el = new Element\Date('date1', array(
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
        
        $el = new Element\Text('title', array(
            'label' => 'Title'
        ));
        $this->add($el);
        
        $el = new Element\Textarea('content', array('label' => 'Beschreibung'));
        $el->setAttribute('class', 'ckeditor');
        $this->add($el);
        
        $el = new Element\Select('calendar', array('label' => 'Calendar'));
        $valueOptions = array();
        foreach ($this->getServiceLocator()->get('KofusNodeService')->getRepository('CAL')->findAll() as $calendar)
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
            ,
            'title' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'Zend\Filter\StringTrim'
                    )
                )
            ),
            'content' => array(
            		'required' => false,
            ),
            'calendar' => array(
            	'required' => true
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

