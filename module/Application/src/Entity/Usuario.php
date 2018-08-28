<?php 
namespace Application\Entity;

class Usuario
{
    public $codUsuario;
    public $rol;
    public $usuario;
    public $clave;
    public $nombres;
    public $primerApellido;
    public $segundoApellido;
    public $imagenPerfil;

    public function exchangeArray(array $data)
    {
        $this->codUsuario        = !empty($data['codUsuario']) ? $data['codUsuario'] : null;
        $this->rol               = !empty($data['rol']) ? $data['rol'] : null;
        $this->usuario           = !empty($data['usuario']) ? $data['usuario'] : null;
        $this->clave             = !empty($data['clave']) ? $data['clave'] : null;
        $this->nombres           = !empty($data['nombres']) ? $data['nombres'] : null;
        $this->primerApellido    = !empty($data['primerApellido']) ? $data['primerApellido'] : null;
        $this->segundoApellido   = !empty($data['segundoApellido']) ? $data['segundoApellido'] : null;
        $this->imagenPerfil      = !empty($data['imagenPerfil']) ? $data['imagenPerfil'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}

