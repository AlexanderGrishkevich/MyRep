<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Post\Controller\Index' => 'Post\Controller\IndexController',
            'Post\Controller\Post'  => 'Post\Controller\PostController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'post' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/post[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Post\Controller\Post',
                        'action'     => 'index',
                    ),
                ),
            ),
        ), 
    ),
   'service_manager' => array(
        'factories' => array(
            'DbAdapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
   ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Post' => __DIR__ . '/../view',
        ),
    ),
);
