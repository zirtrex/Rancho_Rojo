<?php 
namespace Application\Entity;

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
        
        /*$this->Ubicacion = new Ubicacion();
        
        $this->Ubicacion->codUbicacion  = !empty($data['codUbicacion']) ? $data['codUbicacion'] : null;
        $this->Ubicacion->direccion     = !empty($data['direccion']) ? $data['direccion'] : null;
        $this->Ubicacion->distrito      = !empty($data['distrito']) ? $data['distrito'] : null;
        $this->Ubicacion->provincia     = !empty($data['provincia']) ? $data['provincia'] : null;
        $this->Ubicacion->departamento  = !empty($data['departamento']) ? $data['departamento'] : null;*/
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}

