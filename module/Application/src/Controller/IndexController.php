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

class IndexController extends AbstractActionController
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
        $terrenos = $this->terrenosTable->obtenerTodo(false);

        return new ViewModel([
            'terrenos' => Json::encode($terrenos, Json::TYPE_ARRAY),
            'messages' => $this->flashmessenger()->getMessages(),
            'errorMessages' => $this->flashmessenger()->getErrorMessages()
        ]);
    }

    /**
     * Función para listar todos los Lotes
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function listarLotesAction()
    {
        $lotes= $this->terrenosTable->obtenerTodo(true);

        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $itemsPerPage = 20;

        $lotes->setCurrentPageNumber($page);

        $lotes->setItemCountPerPage($itemsPerPage);

        return new ViewModel([
            'lotes' => $lotes,
            'messages' => $this->flashmessenger()->getMessages(),
            'errorMessages' => $this->flashmessenger()->getErrorMessages()
        ]);
    }

    public function listarLotesPorManzanaAction()
    {
        $manzana =  $this->params()->fromRoute('lote', null);

        if (null === $manzana) {
            $this->flashmessenger()->addErrorMessage("Debe elegir una manzana -.");
            return $this->redirect()->toRoute('home');
        }

        try {
            $lotes= $this->terrenosTable->obtenerLotesPorManzana($manzana);
        } catch (RuntimeException $e) {
            $this->flashmessenger()->addErrorMessage("Debe elegir una manzana --.");
            return $this->redirect()->toRoute('home');
        }

        return new ViewModel([
            'manzana' =>  $manzana,
            'lotes' => $lotes,
            'messages' => $this->flashmessenger()->getMessages(),
            'errorMessages' => $this->flashmessenger()->getErrorMessages()
        ]);
    }

    public function listarPagosAction()
    {
        $codTerreno = (int) $this->params()->fromRoute('codTerreno', 0);

        $pagos = $this->pagosTable->obtenerPagosByCodTerreno($codTerreno);

        if (0 === $codTerreno) {
            $this->flashmessenger()->addErrorMessage("Debe elegir un Lote.");
            return $this->redirect()->toRoute('terrenos', ['action' => 'listar-lotes']);
        }

        try {
            $terreno = $this->terrenosTable->obtenerTerreno($codTerreno);
        } catch (RuntimeException $e) {
            $this->flashmessenger()->addErrorMessage("Debe elegir un Lote.");
            return $this->redirect()->toRoute('home');
        }

        return new ViewModel([
            'pagos' => $pagos,
            'terreno' => $terreno,
            'messages' => $this->flashmessenger()->getMessages(),
            'errorMessages' => $this->flashmessenger()->getErrorMessages()
        ]);
    }

    public function generarPagoAction()
    {
        if ($this->identity()) {

            $codTerreno = (int) $this->params()->fromRoute('codTerreno', 0);

            if (0 === $codTerreno) {
                $this->flashmessenger()->addErrorMessage("Debe elegir un terreno.");
                return $this->redirect()->toRoute('home');
            }

            try {
                $terreno = $this->terrenosTable->obtenerTerreno($codTerreno);
            } catch (RuntimeException $e) {
                $this->flashmessenger()->addErrorMessage("Debe elegir un terreno.");
                return $this->redirect()->toRoute('home');
            }

            $formManager = $this->container->get('FormElementManager');
            $form = $formManager->get(PagoForm::class);
            $form->get("codTerreno")->setValue($codTerreno);
            $form->get("codUsuario")->setValue($this->identity()['codUsuario']);

            $request = $this->getRequest();

            if ($request->isPost()) {

                $form->setInputFilter(new PagoFilter());

                $data = array_merge_recursive(
                    $request->getPost()->toArray(),
                    $request->getFiles()->toArray()
                );

                $form->setData($data);

                if ($form->isValid())
                {
                    $pago = $form->getData();

                    $uploadFile = $data['comprobante']; //var_dump($uploadFile['tmp_name']);return ;

                    $comprobantePrev = $form->getInputFilter()->get("comprobante")->getValue();
                    $comprobante = explode("\\", $comprobantePrev['tmp_name']);

                    $terreno = $this->terrenosTable->obtenerTerreno($pago->codTerreno);

                    $nuevoSaldo = $terreno->saldo - $pago->valor;
                    $terreno->saldo = $nuevoSaldo;

                    $codTerreno =  $this->terrenosTable->guardarTerreno($terreno);

                    if($codTerreno){

                        $pago->comprobante= $comprobante[1];
                        $pago->saldoAFecha = $nuevoSaldo;

                        $codPago =  $this->pagosTable->guardarPago($pago);

                        if($codPago){

                            $this->flashmessenger()->addMessage("Pago N°" . $codPago . ", a la " . $terreno->manzana. " Lote: " . $terreno->lote . ", agregado correctamente.");

                            return $this->redirect()->toRoute('home');
                            //return $this->redirect()->toRoute('pagos', array('controller' => 'index'/*, 'action' => 'listar-pagos'*/));

                        }

                    }


                } else {
                    $this->flashmessenger()->addErrorMessage("Datos no validados correctamente.");
                    //throw new \Exception("Datos no validados correctamente.");
                }
            }

            return new ViewModel([
                'codTerreno' => $codTerreno,
                'terreno' => $terreno,
                'form' => $form,
                'messages' => $this->flashmessenger()->getMessages(),
                'errorMessages' => $this->flashmessenger()->getErrorMessages()
            ]);


        } else {
            return $this->redirect()->toRoute('ingresar');
        }
    }

    public function generarVentaAction()
    {
        if ($this->identity()) {

            $codTerreno = (int) $this->params()->fromRoute('codTerreno', 0);

            if (0 === $codTerreno) {
                $this->flashmessenger()->addErrorMessage("Debe elegir un lote.");
                return $this->redirect()->toRoute('home');
            }

            try {
                $terreno = $this->terrenosTable->obtenerTerreno($codTerreno);
            } catch (RuntimeException $e) {
                $this->flashmessenger()->addErrorMessage("Debe elegir un lote.");
                return $this->redirect()->toRoute('home');
            }

            if($terreno->vendido == "En proceso"){

                $this->flashmessenger()->addMessage("Agregar Pago");

                return $this->redirect()->toRoute('pagos', array(
                    'controller' => 'index',
                    'action' => 'generar-pago',
                    'codTerreno' => $codTerreno
                ));
            }

            $formManager = $this->container->get('FormElementManager');
            $form = $formManager->get(TerrenoForm::class);
            $form->bind($terreno); // \Zend\Debug\Debug::dump($empleo); return;
            $form->get('boton')->setAttribute('value', 'Generar Venta');

            $request = $this->getRequest();

            if ($request->isPost()) {

                $form->setInputFilter(new TerrenoFilter());
                $form->setValidationGroup(array('codTerreno', 'lote', 'precio', 'inicial', 'fechaVenta', 'cuotas', 'montoPagar', 'cedulaComprador', 'nombresComprador', 'apellidosComprador', 'telefonoComprador'));

                $form->setData($request->getPost());

                if ($form->isValid()){

                    $terreno = $form->getData();

                    $terreno->vendido = "En proceso";
                    $terreno->fechaVenta = $terreno->fechaVenta; //gmdate("Y-m-d H:i:s", Miscellanea::getHoraLocal(-5));
                    $terreno->saldo = $terreno->precio - $terreno->inicial;

                    $codTerreno =  $this->terrenosTable->guardarTerreno($terreno);

                    if($codTerreno){

                        $this->flashmessenger()->addMessage("_" . $terreno->nombre . ", vendido correctamente.");
                        $this->flashmessenger()->addMessage("Ahora puedes agregar el primer pago.");

                        return $this->redirect()->toRoute('pagos', array(
                            'controller' => 'index',
                            'action' => 'generar-pago',
                            'codTerreno' => $codTerreno
                        ));
                    }


                } else {
                    $this->flashmessenger()->addErrorMessage("Datos no validados correctamente.");
                    //throw new \Exception("Datos no validados correctamente.");
                }
            }

            return new ViewModel([
                'codTerreno' => $codTerreno,
                'terreno' => $terreno,
                'form' => $form,
                'messages' => $this->flashmessenger()->getMessages(),
                'errorMessages' => $this->flashmessenger()->getErrorMessages()
            ]);

        } else {
            return $this->redirect()->toRoute('ingresar');
        }
    }
}
