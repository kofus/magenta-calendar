<?php
return array(
    'nodes' => array(
        'enabled' => array(
            'CAL',
            'CALENT',
            'CALCAT'
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
                        ),
                        'export' => array(
                            'label' => 'Export',
                            'route' => 'kofus_calendar',
                            'controller' => 'calendar',
                            'action' => 'export',
                            'icon' => 'glyphicon glyphicon-export',
                            'params' => array(
                                'id' => '{node_id}'
                            )
                        ),
                        'categories' => array(
                            'label' => 'Categories',
                            'route' => 'kofus_calendar',
                            'controller' => 'category',
                            'action' => 'list'
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
                            'begin' => array(
                                'class' => 'Kofus\Calendar\Form\Fieldset\Entry\BeginFieldset',
                                'hydrator' => 'Kofus\Calendar\Form\Hydrator\Entry\BeginHydrator'
                            ),
                            'end' => array(
                            		'class' => 'Kofus\Calendar\Form\Fieldset\Entry\EndFieldset',
                            		'hydrator' => 'Kofus\Calendar\Form\Hydrator\Entry\EndHydrator'
                            ),
                            'content' => array(
                            		'class' => 'Kofus\Calendar\Form\Fieldset\Entry\ContentFieldset',
                            		'hydrator' => 'Kofus\Calendar\Form\Hydrator\Entry\ContentHydrator'
                            ),
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
            ),
            'CALCAT' => array(
                'label' => 'Kategorie',
                'label_pl' => 'Kategorien',
                'controllers' => array(
                    'Kofus\Calendar\Controller\Category'
                ),
                'entity' => 'Kofus\Calendar\Entity\CategoryEntity',
                'form' => array(
                    'default' => array(
                        'fieldsets' => array(
                            'master' => array(
                                'class' => 'Kofus\Calendar\Form\Fieldset\Category\MasterFieldset',
                                'hydrator' => 'Kofus\Calendar\Form\Hydrator\Category\MasterHydrator'
                            )
                        )
                    )
                ),
                'navigation' => array(
                    'list' => array(
                        'add' => array(
                            'label' => 'Add',
                            'route' => 'kofus_system',
                            'controller' => 'node',
                            'icon' => 'glyphicon glyphicon-plus',
                            'action' => 'add',
                            'params' => array(
                                'id' => 'CALCAT'
                            )
                        )
                    )
                )
            )
        )
    )
)
;