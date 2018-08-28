<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'db' => array(
		'driver' 	=> 'Pdo',
    	'dsn' 		=> 'mysql:dbname=rancho_rojo; host=localhost',
    	'driver_options' => array(
    		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
    	)
	),
    
    'session_validators' => [
        \Zend\Session\Validator\RemoteAddr::class,
        \Zend\Session\Validator\HttpUserAgent::class,
    ],
    
    'session_config' => [
        'remember_me_seconds' => 604800,
        'use_cookies' => true,
        'cookie_lifetime' => 604800,
        'name' => 'session',
    ],
    
    'session_storage' => [
        'type' => \Zend\Session\Storage\SessionArrayStorage::class,
    ],
    
    'mail' => array(
        'transport' => array(
            'options' => array(
                //'host' => 'mail.yahoo.com',
                'host' => 'smtp.gmail.com',
                //'connection_class'  => 'plain',
                'port' => '587', //2525
                'connection_config' => array(
                    'username' => 'zirtrex@gmail.com',
                    'password' => '',
                    'ssl' => 'tls'
                ),
            ),
        ),
    ),
];
