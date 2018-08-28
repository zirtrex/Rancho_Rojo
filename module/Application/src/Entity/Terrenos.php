<?php 
namespace Application\Entity;

use Zend\Json\Json;

class Terrenos
{
    public $codTerreno;
    public $manzana;
    public $codigoLote;
    public $lote;
    public $nombre;
    public $tamanio;
    public $precio;
    public $escrituras;
    public $registroPropiedad;
    public $inicial;
    public $saldo;
    public $vendido;
    public $fechaVenta;
    public $cuotas;
    public $montoPagar;
    public $cordenadas;
    public $cordenadasParse;
    public $cedulaComprador;
    public $nombresComprador;
    public $apellidosComprador;
    public $telefonoComprador;
    public $direccionComprador;

    public function exchangeArray(array $data)
    {
        $this->codTerreno           = !empty($data['codTerreno']) ? $data['codTerreno'] : null;
        $this->manzana              = !empty($data['manzana']) ? $data['manzana'] : null;
        $this->codigoLote           = !empty($data['codigoLote']) ? $data['codigoLote'] : null;
        $this->lote                 = !empty($data['lote']) ? $data['lote'] : null;
        $this->nombre               = !empty($data['nombre']) ? $data['nombre'] : null;
        $this->tamanio              = !empty($data['tamanio']) ? $data['tamanio'] : null;
        $this->precio               = !empty($data['precio']) ? $data['precio'] : null;        
        $this->escrituras           = !empty($data['escrituras']) ? $data['escrituras'] : null;
        $this->registroPropiedad    = !empty($data['registroPropiedad']) ? $data['registroPropiedad'] : null;
        $this->inicial              = !empty($data['inicial']) ? $data['inicial'] : null;
        $this->saldo                = !empty($data['saldo']) ? $data['saldo'] : null;
        $this->vendido              = !empty($data['vendido']) ? $data['vendido'] : null;
        $this->fechaVenta           = !empty($data['fechaVenta']) ? $data['fechaVenta'] : null;
        $this->cuotas               = !empty($data['cuotas']) ? $data['cuotas'] : null;
        $this->montoPagar           = !empty($data['montoPagar']) ? $data['montoPagar'] : null;
        $this->cordenadas           = !empty($data['cordenadas']) ? $data['cordenadas'] : null;
        $this->cedulaComprador      = !empty($data['cedulaComprador']) ? $data['cedulaComprador'] : null;
        $this->nombresComprador     = !empty($data['nombresComprador']) ? $data['nombresComprador'] : null;
        $this->apellidosComprador   = !empty($data['apellidosComprador']) ? $data['apellidosComprador'] : null;
        $this->telefonoComprador    = !empty($data['telefonoComprador']) ? $data['telefonoComprador'] : null;
        $this->direccionComprador   = !empty($data['direccionComprador']) ? $data['direccionComprador'] : null;
        
        //$this->cordenadasParse= Json::decode($this->cordenadas);
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}

