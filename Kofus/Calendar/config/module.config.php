<?php
namespace Kofus\Calendar;

return array(
    'controllers' => array(
        'invokables' => array(
            'Kofus\Calendar\Controller\Index' => 'Kofus\Calendar\Controller\IndexController',
            'Kofus\Calendar\Controller\Calendar' => 'Kofus\Calendar\Controller\CalendarController',
        )
    ),
    'user' => array(
        'controller_mappings' => array(
            'Kofus\Calendar\Controller\Index' => 'Frontend',
            'Kofus\Calendar\Controller\Calendar' => 'Backend',
        )
    ),
    
    'router' => array(
        'routes' => array(
            'calendar' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route' => '/:language/' . KOFUS_ROUTE_SEGMENT . '/calendar/:controller/:action[/:id[/:id2]]',
            				'constraints' => array(
            						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
            						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            						'language' => '[a-z][a-z]'
            				),
            				'defaults' => array(
            						'language' => 'de',
            						'__NAMESPACE__' => 'Kofus\Calendar\Controller'
            				)
            		),
            ),            
        )
    ),
    
    
    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type' => 'phpArray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php'
            )
        )
    ),
    
		/*
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ), */
    
    'controller_plugins' => array(
        'invokables' => array()
    ),
    
    'view_manager' => array(
        'module_layouts' => array(
            'Kofus\Calendar\Controller\Calendar' => 'kofus/layout/admin'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    )
);


