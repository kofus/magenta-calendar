<?php
namespace Kofus\Calendar\Form\Fieldset\Calendar;

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
            'label' => 'Title'
        ));
        $this->add($el);
        
        $el = new Element\MultiCheckbox('holidays', array('label' => 'Holidays'));
        $valueOptions = array();
        $lists = $this->getServiceLocator()->get('KofusConfigService')->get('calendar.holidays.available');
        foreach ($lists as $id => $config) 
            $valueOptions[$id] = $config['label'];
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
            'holidays' => array(
                	'required' => false
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

