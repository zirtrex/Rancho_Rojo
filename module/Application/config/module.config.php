<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'terrenos' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/terrenos[/:action][/:codTerreno][/page/:page][/orderby/:orderby][/:order]',
                    'constraints' => [
                        'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'codTerreno'    => '[0-9]+',
                        'page'          => '[0-9]+',
                        'orderby'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order'         => 'ASC|DESC'
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'terrenos-lote' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/terrenos-lote[/:action][/:lote][/page/:page][/orderby/:orderby][/:order]',
                    'constraints' => [
                        'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'lote'          => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page'          => '[0-9]+',
                        'orderby'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order'         => 'ASC|DESC'
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'pagos' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/pagos[/:action][/:codTerreno][/page/:page][/orderby/:orderby][/:order]',
                    'constraints' => [
                        'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'codTerreno'    => '[0-9]+',
                        'page'          => '[0-9]+',
                        'orderby'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order'         => 'ASC|DESC'
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'reportes' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/reportes[/:action][/:codTerreno][/page/:page][/orderby/:orderby][/:order]',
                    'constraints' => [
                        'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'codTerreno'    => '[0-9]+',
                        'page'          => '[0-9]+',
                        'orderby'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order'         => 'ASC|DESC'
                    ],
                    'defaults' => [
                        'controller' => Controller\ReporteController::class, 
                        'action'     => 'index',
                    ],
                ],
            ],
            'admin' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/admin[/:action][/:codTerreno][/page/:page][/orderby/:orderby][/:order]',
                    'constraints' => [
                        'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'codTerreno'    => '[0-9]+',
                        'page'          => '[0-9]+',
                        'orderby'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order'         => 'ASC|DESC'
                    ],
                    'defaults' => [
                        'controller' => Controller\AdminController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    
    'module_config' => array (
        'upload_location' => __DIR__ . '/../../../public/comprobantes'
    ),
    
    'service_manager' => [
        'factories' => [
            SessionManager::class => SessionManagerFactory::class,
            Storage\AuthStorage::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \Zend\Authentication\AuthenticationService::class => Factory\Storage\AuthenticationServiceFactory::class,
            \Application\Acl\Acl::class => function ($container) {
                $config = include __DIR__ . '/acl.config.php';
                return new \Application\Acl\Acl ( $config );
            } 
        ],
    ],
    
    'controllers' => [
        'factories' => [
            //Controller\ReporteController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Inicio',
                'route' => 'home',
            ),
            array(
                'label' => 'Lotes',
                'route' => 'terrenos',
                'action' => 'listar-lotes',
            ),
            array(
                'label' => 'Pagos',
                'route' => 'pagos',
                'action' => 'listar-pagos',
            ),
            array(
                'label' => 'Reportes',
                'route' => 'reportes',
                'action' => 'index',
            ),        
        ),
    ),
];
