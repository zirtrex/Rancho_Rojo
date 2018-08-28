<?php 
namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Json\Json;
use Application\Entity\Terrenos;
use Zend\Db\Sql\Expression;


class TerrenosTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function obtenerTodo($paginado = false)
    {
        if ($paginado) {
            
            $select = new Select("terrenos");            

            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Terrenos());

            $paginatorAdapter = new DbSelect($select, $this->tableGateway->getAdapter(), $resultSetPrototype);
            
            $paginator = new Paginator($paginatorAdapter);
            
            return $paginator;
        }

        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function obtenerTodoParaReportes($vendido = false)
    {        
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = new Select();
        
        $select->from('terrenos')
            ->columns(array('*'));
        
        $spec = function (Where $where) {
            $where->equalTo('vendido', 'En proceso');
        };
        
        if(!$vendido){ $select->where($spec); } 
        
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Terrenos());
            
        $paginatorAdapter = new DbSelect($select, $this->tableGateway->getAdapter(),$resultSetPrototype);
        
        $paginator = new Paginator($paginatorAdapter);
        
        return $paginator;
    }
    
    public function obtenerTerrenosCount(Array $where = null, $group = null)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = new Select();
        
        $select->from('terrenos')
            ->columns(array('*', 'total' => New Expression('COUNT(*)')));
        
        if($where !== null){ $select->where($where); }
        
        if($group!== null){ $select->group($group); }
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = $statement->execute();
        
        $row = $resultSet->current();
        
        return $row;
    }

    public function obtenerTerreno($codTerreno)
    {
        $codTerreno = (int) $codTerreno;
        $rowset = $this->tableGateway->select(['codTerreno' => $codTerreno]);
        $row = $rowset->current();
        
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d', $codTerreno
            ));
        }

        return $row;
    }
    
    public function obtenerLotesPorManzana($manzana)
    {
        $manzana= (String) $manzana;
        $resulset = $this->tableGateway->select(['manzana' => $manzana]);
        //$row = $rowset->e
        
        if (! $resulset) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d', $manzana
                ));
        }
        
        return $resulset;
    }

    public function guardarTerreno(Terrenos $terreno)
    {
        $data = [
            'manzana'           => $terreno->manzana,
            'codigoLote'        => $terreno->codigoLote,            
            'lote'              => $terreno->lote,
            'nombre'            => $terreno->nombre,
            'tamanio'           => $terreno->tamanio,
            'escrituras'        => $terreno->escrituras,
            'registroPropiedad' => $terreno->registroPropiedad,
            'precio'            => $terreno->precio,            
            'inicial'           => $terreno->inicial,
            'saldo'             => $terreno->saldo,
            'vendido'           => $terreno->vendido,
            'fechaVenta'        => $terreno->fechaVenta,
            'cuotas'            => $terreno->cuotas,
            'montoPagar'        => $terreno->montoPagar,
            'cordenadas'        => $terreno->cordenadas,
            'cedulaComprador'   => $terreno->cedulaComprador,
            'nombresComprador'  => $terreno->nombresComprador,
            'apellidosComprador'=> $terreno->apellidosComprador,
            'telefonoComprador' => $terreno->telefonoComprador,
            'direccionComprador' => $terreno->direccionComprador
        ];

        $codTerreno = (int) $terreno->codTerreno;

        if ($codTerreno === 0) {
            $this->tableGateway->insert($data);
            return $this->tableGateway->lastInsertValue;
        }
        
        if (! $this->obtenerTerreno($codTerreno)) {
            throw new RuntimeException(sprintf(
                'Cannot update row with identifier %d; does not exist', $codTerreno
                ));
        }
        
        $this->tableGateway->update($data, ['codTerreno' => $codTerreno]);
        
        return $codTerreno;
    }

    public function eliminarTerreno($codTerreno)
    {
        return $this->tableGateway->delete(['codTerreno' => (int) $codTerreno]);
    }
}

