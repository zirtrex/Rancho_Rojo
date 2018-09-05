<?php 
namespace Application\Entity;

use Application\Entity\Terrenos;

class Pagos
{
    public $codPago;
    public $numeroCuota;
    public $fechaPago;
    public $formaPago;
    public $valor;
    public $saldoAFecha;
    public $comprobante;
    public $codTerreno;
    public $Terreno;
    public $codUsuario;
    public $fechaCreacion;

    public function exchangeArray(array $data)
    {
        $this->codPago          = !empty($data['codPago']) ? $data['codPago'] : null;
        $this->numeroCuota      = !empty($data['numeroCuota']) ? $data['numeroCuota'] : null;
        $this->fechaPago        = !empty($data['fechaPago']) ? $data['fechaPago'] : null;
        $this->formaPago        = !empty($data['formaPago']) ? $data['formaPago'] : null;
        $this->valor            = !empty($data['valor']) ? $data['valor'] : null;
        $this->saldoAFecha      = !empty($data['saldoAFecha']) ? $data['saldoAFecha'] : null;
        $this->comprobante      = !empty($data['comprobante']) ? $data['comprobante'] : null;
        $this->codTerreno       = !empty($data['codTerreno']) ? $data['codTerreno'] : null;
        $this->codUsuario       = !empty($data['codUsuario']) ? $data['codUsuario'] : null;
        $this->fechaCreacion    = !empty($data['fechaCreacion']) ? $data['fechaCreacion'] : null;
        
        $this->Terreno = new Terrenos();
        
        $this->Terreno->codTerreno          = !empty($data['codTerreno']) ? $data['codTerreno'] : null;
        $this->Terreno->codLote             = !empty($data['codLote']) ? $data['codLote'] : null;
        $this->Terreno->lote                = !empty($data['lote']) ? $data['lote'] : null;
        $this->Terreno->nombresComprador    = !empty($data['nombresComprador']) ? $data['nombresComprador'] : null;
        $this->Terreno->apellidosComprador  = !empty($data['apellidosComprador']) ? $data['apellidosComprador'] : null;
        $this->Terreno->telefonoComprador   = !empty($data['telefonoComprador']) ? $data['telefonoComprador'] : null;
        $this->Terreno->direccionComprador  = !empty($data['direccionComprador']) ? $data['direccionComprador'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}

