<?php
namespace Users;

use Zend\Db\Adapter\AdapterInterface;
use Application\Factory\MailFactory;
use Application\Model\UsuarioTable;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\RegistroController::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\RegistroController(
                        $container->get(UsuarioTable::class),
                        $dbAdapter,
                        $container->get(MailFactory::class)
                    );
                },
                Controller\PerfilController::class => function ($container) {
                    return new Controller\PerfilController(
                        $container,
                        $container->get(UsuarioTable::class)
                    );
                }
            ]
        ];
    }
}
















