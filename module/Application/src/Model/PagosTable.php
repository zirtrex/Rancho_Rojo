<?php 
namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Sql;
use Application\Entity\Pagos;
use Zend\Db\Sql\Expression;

class PagosTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function obtenerTodo($paginado = false)
    {
        if ($paginado) {
            
            $select = new Select();
            
            $select->from('vw_pagos')
                ->order('fechaPago DESC');

            //$resultSetPrototype = new ResultSet();
            //$resultSetPrototype->setArrayObjectPrototype(new Pagos());

            $paginatorAdapter = new DbSelect($select, $this->tableGateway->getAdapter(), null/*$resultSetPrototype*/);
            
            $paginator = new Paginator($paginatorAdapter);
            
            return $paginator;
        }
        
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function obtenerPagosByCodTerreno($codTerreno, $paginado = true)
    {
        if ($paginado) {

            $select = new Select();
            
            $select->from('vw_pagos')
                ->order('fechaPago DESC');
            
            if($codTerreno !== null){ $select->where(array('codTerreno' => $codTerreno)); }
            
            $paginatorAdapter = new DbSelect($select, $this->tableGateway->getAdapter(), null/*$resultSetPrototype*/);
            
            $paginator = new Paginator($paginatorAdapter);
            
            return $paginator;
        }
        
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function obtenerUltimoPagoByCodTerreno($codTerreno)
    {
        $sql = new Sql($this->tableGateway->getAdapter());            
        $select = new Select();
        $select->from('vw_pagos')
                ->columns(['precio', 'fechaPago', 'valor', 'montoPagar'])
                ->order('fechaPago DESC')                
                ->where(['codTerreno' => $codTerreno])
                ->limit(1);
            
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = $statement->execute();
        
        $row = $resultSet->current();
        
        return $row;
    }
    
    public function obtenerTotalPagos(Array $where = null, $group = null)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = new Select();
        
        $select->from('pagos')
            ->columns(array('valor', 'total' => New Expression('SUM(valor)')));
        
        if($where !== null){ $select->where($where); }
        
        if($group!== null){ $select->group($group); }
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = $statement->execute();
        
        $row = $resultSet->current();
        
        return $row;
    }
    
    public function obtenerPagosCount(Array $where = null, $group = null)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = new Select();
        
        $select->from('pagos')
            ->columns(array('*', 'total' => New Expression('COUNT(*)')));
        
        if($where !== null){ $select->where($where); }
        
        if($group!== null){ $select->group($group); }
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = $statement->execute();
        
        $row = $resultSet->current();
        
        return $row;
    }

    public function obtenerPago($codPago)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql->select();
        
        $select->from('pagos')
                ->columns(array('*'))
                ->where(array('codPago' => $codPago));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $row = $statement->execute();
        
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d', $codPago
            ));
        }

        return $row->current();
    }

    public function guardarPago(Pagos $pago)
    {
        $data = [
            'numeroCuota'   => $pago->numeroCuota,
            'fechaPago'     => $pago->fechaPago,
            'formaPago'     => $pago->formaPago,
            'valor'         => $pago->valor,
            'saldoAFecha'   => $pago->saldoAFecha,
            'comprobante'   => $pago->comprobante,
            'codTerreno'    => $pago->codTerreno,
            'codUsuario'    => $pago->codUsuario,
            'fechaCreacion' => gmdate("Y-m-d H:i:s", Miscellanea::getHoraLocal(-5))
        ];

        $codPago = (int) $pago->codPago;

        if ($codPago === 0) {
            $this->tableGateway->insert($data);
            return $this->tableGateway->lastInsertValue;
        }

        if (! $this->obtenerPago($codPago)) {
            throw new RuntimeException(sprintf(
                'Cannot update row with identifier %d; does not exist', $codPago
            ));
        }

        $this->tableGateway->update($data, ['codPago' => $codPago]);
        
        return $codPago;
    }

    public function eliminarPago($codPago)
    {
        $this->tableGateway->delete(['codPago' => (int) $codPago]);
    }
}

