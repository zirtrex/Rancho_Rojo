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

class ReporteController extends AbstractActionController 
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
        $totalTerrenos = $this->terrenosTable->obtenerTerrenosCount();  //var_dump($totalTerrenos); return;
        $totalVendidos = $this->terrenosTable->obtenerTerrenosCount(['vendido' => 'Si']);
        $totalEnProceso = $this->terrenosTable->obtenerTerrenosCount(['vendido' => 'En proceso']);
        $totalSinVender = $this->terrenosTable->obtenerTerrenosCount(['vendido' => 'Libre']);
         
        return new ViewModel([
            'totalTerrenos' => $totalTerrenos["total"],
            'totalVendidos' => $totalVendidos["total"],
            'totalEnProceso' => $totalEnProceso["total"],
            'totalSinVender' => $totalSinVender["total"],
            'messages' => $this->flashmessenger()->getMessages(),
            'errorMessages' => $this->flashmessenger()->getErrorMessages()
        ]);
    }
    
    public function pagosAction()
    {
        $totalTerrenos = $this->terrenosTable->obtenerTerrenosCount();
        $terrenos = $this->terrenosTable->obtenerTodo(false);
        $tPagados = 0;
        $tSinPagar = 0;
        
        foreach ($terrenos as $terreno){
            $codTerreno = $terreno->codTerreno;
            $terrenosPagados = (int) $this->pagosTable->obtenerPagosCount(['codTerreno' => $codTerreno])["total"];
            //var_dump($terrenosPagados); echo "<br/>";
            if($terrenosPagados > 0){
                $tPagados++; 
            }else{
                $tSinPagar++;
            }
        }
        
        return new ViewModel([
            'totalTerrenos' => $totalTerrenos["total"],
            'tPagados' => $tPagados,
            'tSinPagar' => $tSinPagar,
            'messages' => $this->flashmessenger()->getMessages(),
            'errorMessages' => $this->flashmessenger()->getErrorMessages()
        ]);
    }
    
    public function pagosAtrasadosAction()
    {
        $codTerreno = (int) $this->params()->fromRoute('codTerreno', 0);
        
        $resulsetLotes= $this->terrenosTable->obtenerTodoParaReportes(false);
        $lotes = [];
        
        if($resulsetLotes->count() != 0)
        {
            foreach ($resulsetLotes as $lote)
            {
                $codTerreno = $lote->codTerreno;
                $pago = $this->pagosTable->obtenerUltimoPagoByCodTerreno($codTerreno);
                $totalPagado = $this->pagosTable->obtenerTotalPagos(['codTerreno' => $codTerreno])["total"];                
                
                if($pago['fechaPago'])
                {
                    $lote->ultimaFechaPago = $pago['fechaPago'];
                    $lote->ultimoMontoPago = $pago['valor'];
                    
                    $datetime1 = date_create("now");
                    $datetime2 = date_create($pago['fechaPago']);
                    $interval = date_diff($datetime1, $datetime2);
                    $dias = $interval->format('%R%a');
                    
                    $lote->diasAtraso = $dias . " días";
                    
                    if($dias < 0) $dias = abs($dias);
                    
                    $meses = round($dias / 30);
                    
                    $lote->mesesAtraso = $meses . " meses";
                    $totalDeudaAtrasada = round($meses * $pago['montoPagar'], 2);
                    
                    $lote->totalPagado = $totalPagado;
                    $totalDeuda = $lote->precio - $lote->inicial - $totalPagado;
                    
                    if($totalDeudaAtrasada < $totalDeuda){
                        $diferencial = $totalDeuda - $totalDeudaAtrasada;
                    }else{
                        $diferencial = $totalDeuda;
                    }
                    
                    $lote->totalDeuda = $diferencial;
                }                
                
                array_push($lotes, $lote);
            }
        }        
        
        //$pagos = $this->pagosTable->obtenerPagosByCodTerreno($codTerreno);        
        
        
        return new ViewModel([
            'lotes' => $lotes,
            'messages' => $this->flashmessenger()->getMessages(),
            'errorMessages' => $this->flashmessenger()->getErrorMessages()
        ]);
    }
    
    /**
     * Función para listar todos los Lotes en el area de reportes
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function listarLotesAction()
    {
        $lotes= $this->terrenosTable->obtenerTodo(true);
        
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
        
        $itemsPerPage = 6;
        
        $lotes->setCurrentPageNumber($page);
        
        $lotes->setItemCountPerPage($itemsPerPage);
        
        return new ViewModel([
            'lotes' => $lotes,
            'messages' => $this->flashmessenger()->getMessages(),
            'errorMessages' => $this->flashmessenger()->getErrorMessages()
        ]);
    }

}
