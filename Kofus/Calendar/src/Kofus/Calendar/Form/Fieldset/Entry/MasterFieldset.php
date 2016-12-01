<?php
namespace Kofus\Calendar\Form\Fieldset\Entry;

use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Filter;

class MasterFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function init()
    {
        $el = new Element\Text('date', array(
            'label' => 'Date'
        ));
        $el->setAttribute('class', 'datepicker');
        $this->add($el);
        
        //$el = new Element\Text('time', array('label' => 'Time'));
        //$this->add($el);
        
        $el = new Element\Text('title', array(
            'label' => 'Title'
        ));
        $this->add($el);
        
        $el = new Element\Checkbox('enabled', array(
            'label' => 'enabled?'
        ));
        $this->add($el);
    }

    public function getInputFilterSpecification()
    {
        return array(
            'date' => array(
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
            /*
            'time' => array(
            		'required' => false,
            		
            ),   */          
            'title' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'Zend\Filter\StringTrim'
                    )
                )
            )
        );
    }
}

