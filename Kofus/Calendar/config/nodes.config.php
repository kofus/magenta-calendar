<?php
return array(
    'nodes' => array(
        'enabled' => array('CAL', 'CALENT'),
        'available' => array(
            'CAL' => array(
                'label' => 'Calendar',
                'entity' => 'Kofus\Calendar\Entity\CalendarEntity',
                'controllers' => array(
                    'Kofus\Calendar\Controller\Calendar'
                ),
                'form' => array(
                    'default' => array(
                        'fieldsets' => array(
                            'master' => array(
                                'class' => 'Kofus\Calendar\Form\Fieldset\Calendar\MasterFieldset',
                                'hydrator' => 'Kofus\Calendar\Form\Hydrator\Calendar\MasterHydrator'
                            ),
                        )
                    )
                )
            ),
            'CALENT' => array(
            		'label' => 'Calendar Entry',
            		'entity' => 'Kofus\Calendar\Entity\EntryEntity',
            		'form' => array(
            				'default' => array(
            						'fieldsets' => array(
            								'master' => array(
            										'class' => 'Kofus\Calendar\Form\Fieldset\Entry\MasterFieldset',
            										'hydrator' => 'Kofus\Calendar\Form\Hydrator\Entry\MasterHydrator'
            								),
            						)
            				)
            		)
            ),
            
        )
        
    )
);