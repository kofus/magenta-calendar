<?php
return array(
    'nodes' => array(
        'enabled' => array(
            'CAL',
            'CALENT'
        ),
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
                            )
                        )
                    )
                ),
                'navigation' => array(
                    'month' => array(
                        'add' => array(
                            'label' => 'Termin',
                            'route' => 'kofus_system',
                            'controller' => 'node',
                            'icon' => 'glyphicon glyphicon-plus',
                            'action' => 'add',
                            'params' => array(
                                'id' => 'CALENT'
                            )
                        ),
                        'edit' => array(
                            'label' => 'Edit',
                            'route' => 'kofus_system',
                            'controller' => 'node',
                            'action' => 'edit',
                            'icon' => 'glyphicon glyphicon-pencil',
                            'params' => array(
                                'id' => '{node_id}'
                            )
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
                            )
                        )
                    )
                )
            ),
            'CALENTB' => array(
            		'label' => 'Date of Birth',
            		'entity' => 'Kofus\Calendar\Entity\DateOfBirthEntity',
            		'form' => array(
            				'default' => array(
            						'fieldsets' => array(
            								'master' => array(
            										'class' => 'Kofus\Calendar\Form\Fieldset\DateOfBirth\MasterFieldset',
            										'hydrator' => 'Kofus\Calendar\Form\Hydrator\DateOfBirth\MasterHydrator'
            								)
            						)
            				)
            		)
            )
        )
    )
)
;