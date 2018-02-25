<?php
namespace Kofus\Calendar\Form\Fieldset\Category;

use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MasterFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{

    public function init()
    {
        $this->setLabel('');
        
        $el = new Element\Text('title', array(
            'label' => 'Title'
        ));
        $this->add($el);
        
        $el = new Element\Color('bg_color', array(
            'label' => 'Hintergrundfarbe'
        ));
        $this->add($el);
        
        $el = new Element\Color('color', array(
            'label' => 'Textfarbe'
        ));
        $this->add($el);
        
        $el = new Element\Number('priority', array(
            'label' => 'Priorität'
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
            'bg_color' => array(
                'required' => true
            ),
            'color' => array(
                'required' => true
            ),
            'priority' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'Zend\Filter\Digits')
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

