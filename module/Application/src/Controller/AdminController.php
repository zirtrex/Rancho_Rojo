<?php

namespace Application\Controller;

use RuntimeException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Interop\Container\ContainerInterface;
use Zend\Json\Json;
use Application\Entity\Terrenos;
use Application\Model\TerrenosTable;
use Application\Model\PagosTable;
use Application\Model\UsuarioTable;
use Application\Model\Miscellanea;
use Application\Form\PagoForm;
use Application\Form\Filter\PagoFilter;
use Application\Form\TerrenoForm;
use Application\Form\Filter\TerrenoFilter;

class AdminController extends AbstractActionController 
{
    private $container;
    private $terrenosTable;
    private $pagosTable;
    private $usuarioTable;
    
    
    public function __construct(ContainerInterface $container,
                                TerrenosTable $terrenosTable,
                                PagosTable $pagosTable,
                                UsuarioTable $usuarioTable)
    {
        $this->container = $container;
        $this->terrenosTable = $terrenosTable;
        $this->pagosTable = $pagosTable;
        $this->usuarioTable = $usuarioTable;
    }
    
    public function indexAction()
    {        
        return new ViewModel([
            'messages' => $this->flashmessenger()->getMessages(),
            'errorMessages' => $this->flashmessenger()->getErrorMessages()
        ]);
    }    
    
    public function agregarTerrenoAction()
    {
        if ($this->identity()) {
            
            $formManager = $this->container->get('FormElementManager');
            $form = $formManager->get(TerrenoForm::class);
            $form->get('boton')->setAttribute('value', 'Agregar Terreno');
            
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                
                $form->setInputFilter(new TerrenoFilter());
                $form->setValidationGroup(array('manzana', 'lote', 'tamanio', 'escrituras', 'registroPropiedad', 'precio'));
                
                $form->setData($request->getPost());
                
                if ($form->isValid()){
                    
                    $terreno = $form->getData();
                        
                    $terreno->vendido = "Libre";
                    
                    $codTerreno =  $this->terrenosTable->guardarTerreno($terreno);
                    
                    if($codTerreno){
                            
                        $this->flashmessenger()->addMessage($terreno->manzana . " Lote " . $terreno->lote . ", agregado correctamente.");
                        $this->flashmessenger()->addMessage("Agregar otro");
                        
                        return $this->redirect()->toRoute('admin', array(
                            'controller' => 'admin',
                            'action' => 'agregar-terreno'
                        ));                            
                    }
                                    
                    
                } else {
                    $this->flashmessenger()->addErrorMessage("Datos no validados correctamente.");
                    //throw new \Exception("Datos no validados correctamente.");
                }
            }
            
            return new ViewModel([
                'form' => $form,
                'messages' => $this->flashmessenger()->getMessages(),
                'errorMessages' => $this->flashmessenger()->getErrorMessages()
            ]);
            
        } else {
            //return $this->redirect()->toRoute('ingresar');
        }
    }
    
    public function editarTerrenoAction()
    {
        if ($this->identity()) {
        
        $codTerreno = (int) $this->params()->fromRoute('codTerreno', 0);
        
        if (0 === $codTerreno) {
            $this->flashmessenger()->addErrorMessage("Debe elegir un lote.");
            return $this->redirect()->toRoute('terrenos');
        }
        
        try {
            $terreno = $this->terrenosTable->obtenerTerreno($codTerreno);
        } catch (RuntimeException $e) {
            $this->flashmessenger()->addErrorMessage("Debe elegir un lote.");
            return $this->redirect()->toRoute('home');
        }        
        
        $formManager = $this->container->get('FormElementManager');
        $form = $formManager->get(TerrenoForm::class);
        $form->bind($terreno); // \Zend\Debug\Debug::dump($empleo); return;
        $form->get('boton')->setAttribute('value', 'Editar Terreno');
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            $form->setInputFilter(new TerrenoFilter());
            //$form->setValidationGroup(array('codTerreno', 'manzana', 'lote', 'precio', 'fechaVenta', 'cuotas', 'montoPagar', 'nombresComprador', 'apellidosComprador', 'telefonoComprador'));
            $form->setValidationGroup(array('codTerreno', 'manzana', 'lote', 'tamanio', 'escrituras', 'registroPropiedad', 'precio', 'inicial', 'vendido', 'fechaVenta', 'cedulaComprador', 'nombresComprador', 'apellidosComprador', 'telefonoComprador'));
            
            $form->setData($request->getPost());
            
            if ($form->isValid()){
                
                $terreno = $form->getData();
                
                $codTerreno =  $this->terrenosTable->guardarTerreno($terreno);
                
                if($codTerreno){
                    
                    $this->flashmessenger()->addMessage("Lote " . $terreno->lote . ", editado correctamente.");
                    
                    return $this->redirect()->toRoute('terrenos', array(
                        'controller' => 'index',
                        'action' => 'listar-lotes'
                    ));
                }
                
                
            } else {
                $this->flashmessenger()->addErrorMessage("Datos no validados correctamente.");
                //throw new \Exception("Datos no validados correctamente.");
            }
        }
        
        return new ViewModel([
            'form' => $form,
            'codTerreno' => $codTerreno,
            'terreno' => $terreno,
            'messages' => $this->flashmessenger()->getMessages(),
            'errorMessages' => $this->flashmessenger()->getErrorMessages()
        ]);
        
        } else {
            return $this->redirect()->toRoute('ingresar');
        }
    }
    
    public function eliminarPagoAction()
    {
        if ($this->identity()) {
            
            $codTerreno = (int) $this->params()->fromRoute('codTerreno', 0);
            $codPago = (int) $this->params()->fromRoute('codPago', 0); // \Zend\Debug\Debug::dump($codPago); return;
            
            if (0 === $codPago) {
                $this->flashmessenger()->addErrorMessage("Debe elegir un pago 1.");
                return $this->redirect()->toRoute('terrenos', ['action'=>'listar-pagos', 'codTerreno' => $codTerreno]);
            }
            
            try {
                $pago = $this->pagosTable->obtenerPago($codPago);
            } catch (RuntimeException $e) {
                $this->flashmessenger()->addErrorMessage("Debe elegir un pago 2.");
                return $this->redirect()->toRoute('terrenos', ['action'=>'listar-pagos', 'codTerreno' => $codTerreno]);
            }     
            
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                $del = $request->getPost('del', 'No');
                
                if ($del == 'Si') {
                
                    $codPago =  $this->pagosTable->eliminarPago($pago->codPago); //\Zend\Debug\Debug::dump($codPago); return; 
                    
                    if($codPago){
                        
                        $terreno = $this->terrenosTable->obtenerTerreno($pago->codTerreno);
                        
                        $totalPagos = $this->pagosTable->obtenerTotalPagos(['codTerreno' => $pago->codTerreno]);
                        
                        $nuevoSaldo = $terreno->precio - $terreno->inicial - $totalPagos['total'];
                        $terreno->saldo = $nuevoSaldo;
                        
                        $codTerreno =  $this->terrenosTable->guardarTerreno($terreno);
                        
                        if($codTerreno){
                            
                            $this->flashmessenger()->addMessage("Pago N°" . $pago->codPago. ", a la " . $terreno->manzana. " Lote: " . $terreno->lote . ", eliminado correctamente.");
                            
                            return $this->redirect()->toRoute('terrenos', ['action'=>'listar-pagos', 'codTerreno' => $codTerreno]);                            
                            
                        }
                        
                    }
                }
                // Redirect al listado de pagos
                return $this->redirect()->toRoute('terrenos', ['action'=>'listar-pagos', 'codTerreno' => $codTerreno]);
            }
            return [
                'codTerreno'    => $codTerreno,
                'codPago'       => $codPago,
                'pago'          => $pago,
            ];
            
        } else {
            return $this->redirect()->toRoute('ingresar');
        }
    }
}
