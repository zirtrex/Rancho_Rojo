<?php
namespace Application;

use Zend\Authentication\AuthenticationService;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mail\Transport\Sendmail;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Application\Model\TerrenosTable;
use Application\Model\PagosTable;
use Application\Model\UsuarioTable;
use Application\Acl\Acl;


class Module implements ConfigProviderInterface
{
    const VERSION = '1.0-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\UsuarioTable::class => function ($container) {
                    $tableGateway = $container->get(Model\UsuarioTableGateway::class);
                    return new Model\UsuarioTable($tableGateway);
                },
                Model\UsuarioTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Entity\Usuario());
                    return new TableGateway('usuario', $dbAdapter, null, $resultSetPrototype);
                },
                
                Model\TerrenosTable::class => function ($container) {
                    $tableGateway = $container->get(Model\TerrenosTableGateway::class);
                    return new Model\TerrenosTable($tableGateway);
                },
                Model\TerrenosTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Entity\Terrenos());
                    return new TableGateway('terrenos', $dbAdapter, null, $resultSetPrototype);
                },                
                
                Model\PagosTable::class => function ($container) {
                    $tableGateway = $container->get(Model\PagosTableGateway::class);
                    return new Model\PagosTable($tableGateway);
                },
                Model\PagosTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    return new TableGateway('pagos', $dbAdapter, null);
                },                
                
                Factory\MailFactory::class => function ($container) {
                    $config = $container->get('config');
                    $transport = new Sendmail();
                    if (isset($config['mail']['transport']['options'])) {
                        // $transport->setOptions(new SmtpOptions($config['mail']['transport']['options']));
                    } else {
                        throw new RuntimeException(sprintf('Could not find row with identifier'));
                    }
                    return $transport;
                }
                
            ]
        ];
    }
    
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\IndexController::class => function ($container) {
                    return new Controller\IndexController(
                        $container,
                        $container->get(TerrenosTable::class),
                        $container->get(PagosTable::class),
                        $container->get(UsuarioTable::class)
                        );
                },
                Controller\ReporteController::class => function ($container) { 
                    return new Controller\ReporteController(
                        $container,
                        $container->get(TerrenosTable::class),
                        $container->get(PagosTable::class),
                        $container->get(UsuarioTable::class)
                        );
                },
                Controller\AdminController::class => function ($container) {
                    return new Controller\AdminController(
                        $container,
                        $container->get(TerrenosTable::class),
                        $container->get(PagosTable::class),
                        $container->get(UsuarioTable::class)
                        );
                },
            ]
        ];
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => [
                View\Helper\UsuarioHelper::class => function ($container) {
                    $usuarioHelper = new View\Helper\UsuarioHelper($container);
                    return $usuarioHelper;
                }
            ],
                'aliases' => [
                    'usuario_helper' =>  View\Helper\UsuarioHelper::class
                ]
        );
    }
    
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        // $this->bootstrapSession($mvcEvent);
        $this->auth = $mvcEvent->getApplication()
            ->getServiceManager()
            ->get(AuthenticationService::class);
        
        $mvcEvent->getApplication()->getEventManager()->attach('route', array($this, 'onRoute'), -150);
    
        if ($this->auth->hasIdentity()) {
            $mvcEvent->getViewModel()->setVariable('authIdentity', $this->auth->getIdentity());
        } else {}
    }
    
    public function onRoute(\Zend\EventManager\EventInterface $e) {
        
        $application = $e->getApplication();
        $routeMatch = $e->getRouteMatch();
        $sm = $application->getServiceManager();
        $auth = $sm->get(AuthenticationService::class);
        $acl = $sm->get(Acl::class);
        // everyone is guest until logging in
        $role = Acl::DEFAULT_ROLE; // The default role is guest $acl
        
        if ($auth->hasIdentity())
        {
            $user = $auth->getIdentity();
            $role = ($auth->getStorage()->read()['rol'] == 'admin') ? 'admin' : 'user';
        }
        
        $controller = $routeMatch->getParam('controller');
        $action = $routeMatch->getParam('action');
        
        if (!$acl->hasResource($controller)){
            throw new \Exception('Resource ' . $controller . ' not defined');
        }
        
        if (!$acl->isAllowed($role, $controller, $action))
        {
            $response = $e->getResponse();
            
            if($auth->hasIdentity())
            {
                if($role == "user"){
                    
                    $url = $e->getRouter()->assemble(array(), array('name' => 'home')); // Route que se debe dirigir si tiene sesión y es docente
                    
                    $response->getHeaders()->addHeaders(array(
                        array('Location' => $url)
                    ));
                    $response->setStatusCode(302);
                    $response->sendHeaders();
                    exit;
                }else{
                    $url = $e->getRouter()->assemble(array(), array('name' => 'admin')); // Route que se debe dirigir si tiene sesión y es administrador
                    
                    $response->getHeaders()->addHeaders(array(
                        array('Location' => $url)
                    ));
                    $response->setStatusCode(302);
                    $response->sendHeaders();
                    exit;
                }
            }else{
                
                $url = $e->getRouter()->assemble(array(), array('name' => 'ingresar')); // Route que se tiene que dirigir si no tiene sesión
                
                $response->getHeaders()->addHeaders(array(
                    array('Location' => $url)
                ));
                $response->setStatusCode(302);
                $response->sendHeaders();
                exit;
            }
        }
    }
    
    private function bootstrapSession($e)
    {
        $session = $e->getApplication()
            ->getServiceManager()
            ->get(SessionManager::class);
        
        $session->start();
        
        $container = new Container('session', $session);
        
        if (isset($container->init)) {
            return;
        }
        
        $request = $e->getRequest();
        $session->regenerateId(true);
        $container->init = 1;
        
        $container->remoteAddr = $request->getServer()->get('REMOTE_ADDR');
        $container->httpUserAgent = $request->getServer()->get('HTTP_USER_AGENT');
        
        $config = $e->getApplication()
            ->getServiceManager()
            ->get('config');
        
        if (! isset($config['session'])) {
            return;
        }
        if (! isset($config['session_validators'])) {
            return;
        }
        $chain = $session->getValidatorChain();
        
        foreach ($config['session_validators'] as $validator) {
            switch ($validator) {
                case HttpUserAgent::class:
                    $validator = new $validator($container->httpUserAgent);
                    break;
                case RemoteAddr::class:
                    $validator = new $validator($container->remoteAddr);
                    break;
                default:
                    $validator = new $validator();
            }
            $chain->attach('session.validate', [
                $validator,
                'isValid'
            ]);
        }
    }
}
