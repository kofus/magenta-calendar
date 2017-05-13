<?php
namespace Kofus\Calendar\Form\Fieldset\Entry;

use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContentFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{

    public function init()
    {
        //$this->setLabel('Details');
        
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
        
        $el = new Element\Text('color', array('label' => 'Color'));
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
            'content' => array(
            		'required' => false,
            ),
            'calendar' => array(
            	'required' => true
            ),
            'color' => array(
            	'required' => false,
                'filters' => array(
            	   array('name' => 'Zend\Filter\Null'),
                    array('name' => 'Zend\Filter\StringTrim')
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

