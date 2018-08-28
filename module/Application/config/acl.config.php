<?php

return array(
    'acl' => array(
        'roles' => array(
            'invitado' => null,
            'user' => null,
            'admin' => null
        ),
        'resources' => array(
            'allow' => array(
                Users\Controller\AuthController::class => array(
                    'index' => 'invitado',
                    'salir' => array(
                        'user',
                        'admin'
                    )
                ),
                
                Users\Controller\PerfilController::class => array(
                    'index' => array(
                        'user',
                        'admin'
                    ),
                    'editar-perfil' => array(
                        'user',
                        'admin'
                    ),
                    'cambiar-clave' => array(
                        'user',
                        'admin'
                    ),
                    'subir-imagen' => ['admin', 'user'],
                ),
                
                Users\Controller\ReestablecerClaveController::class => array(
                    'index' => 'invitado',
                    'confirmar-cambio-clave' => 'invitado'
                ),

                Users\Controller\RegistroController::class => array(
                    'index' => array(
                        'user',
                        'admin'
                    ),
                    'pdf' => array(
                        'user',
                        'admin'
                    )
                ),
                
                Application\Controller\AdminController::class=> array(
                    'index'             => 'admin',
                    'agregar-terreno'   => 'admin',
                    'editar-terreno'    => 'admin',
                ),      
                
                Application\Controller\IndexController::class => array(
                    'index'                     => ['admin', 'user'],
                    'listar-lotes'              => ['admin', 'user'],
                    'listar-lotes-por-manzana'  => ['admin', 'user'],
                    'listar-pagos'              => ['admin', 'user'],
                    'generar-pago'              => ['admin', 'user'],
                    'generar-venta'             => ['admin', 'user'],
                ),
                
                Application\Controller\ReporteController::class => array(
                    'index'             => 'admin',
                    'pagos-atrasados'   => ['admin', 'user'],
                    'pagos'             => 'admin',
                ),
            
            ),
            
            /*'deny' => array(
                
                'Users\Controller\Auth' => array(
                    'index' => array(
                        'docente',
                        'admin'
                    ),
                    'salir' => 'invitado'
                ),
                
                'Users\Controller\Perfil' => array(
                    'index' => 'invitado',
                    'editar-perfil' => 'invitado',
                    'cambiar-clave' => 'invitado',
                    'subir-imagen' => 'invitado'
                )
            
            )*/
        )
    )
);