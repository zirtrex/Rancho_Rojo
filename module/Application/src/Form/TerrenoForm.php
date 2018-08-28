<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Hydrator\Reflection as ReflectionHydrator;
use Application\Entity\Terrenos;

class TerrenoForm extends Form
{

    public function init()
    {
        parent::__construct('TerrenoForm');
        $this->setAttribute('method', 'post');
        
        $this->setHydrator(new ReflectionHydrator(false))->setObject(new Terrenos());        
        
        $this->add(array(
            'name' => 'codTerreno',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'codTerreno'
            )
        ));
        
        $this->add(array(
            'name' => 'manzana',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'manzana',
                'class' => 'uk-select'
            ),
            'options' => array(
                'label' => 'Seleccione la manzana',
                'value_options' => [
                    'Manzana_1' => 'Manzana_1',
                    'Manzana_2' => 'Manzana_2',
                    'Manzana_3' => 'Manzana_3',
                    'Manzana_4' => 'Manzana_4',
                    'Manzana_A' => 'Manzana_A',
                    'Manzana_B' => 'Manzana_B',
                    'Manzana_5' => 'Manzana_5',
                    'Manzana_6' => 'Manzana_6',
                    'Manzana_7' => 'Manzana_7',
                    'Manzana_8' => 'Manzana_8',
                    'Manzana_9' => 'Manzana_9',
                    'Manzana_10' => 'Manzana_10',
                    'Manzana_11' => 'Manzana_11',
                    'Manzana_C' => 'Manzana_C',
                    'Manzana_D' => 'Manzana_D',
                    'Manzana_E' => 'Manzana_E',
                    'Manzana_12' => 'Manzana_12',
                    'Manzana_13' => 'Manzana_13',
                    'Manzana_14' => 'Manzana_14',
                    'Manzana_15' => 'Manzana_15',
                    'Manzana_16' => 'Manzana_16',
                    'Manzana_17' => 'Manzana_17',
                    'Manzana_18' => 'Manzana_18',
                    'Manzana_19' => 'Manzana_19',
                    'Manzana_20' => 'Manzana_20',
                    'Manzana_21' => 'Manzana_21',
                    'Manzana_22' => 'Manzana_22',
                    'Manzana_23' => 'Manzana_23',
                    'Manzana_24' => 'Manzana_24',
                    'Manzana_25' => 'Manzana_25',
                    'Manzana_26' => 'Manzana_26',
                    'Manzana_27' => 'Manzana_27',
                    'Manzana_28' => 'Manzana_28',
                ],
                'label_attributes' => array(
                    'class' => ''
                )
            )
        ));
        
        $this->add(array(
            'name' => 'codigoLote',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'lote',
                'placeholder' => 'Ingrese el código de lote',
                'class' => 'uk-input'
            ),
            'options' => array(
                'label' => 'Código de Lote',
            )
        ));
        
        $this->add(array(
            'name' => 'lote',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'lote',
                'placeholder' => 'Ingrese el número de lote',
                'class' => 'uk-input'
            ),
            'options' => array(
                'label' => 'Lote',
            )
        ));        
        
        $this->add(array(
            'name' => 'nombre',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'nombre',
                'placeholder' => 'Ingrese el nombre',
                'required' => 'required',
                'class' => 'uk-input'
            ),
            'options' => array(
                'label' => 'Nombre',
            )
        ));
        
        $this->add(array(
            'name' => 'tamanio',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'tamanio',
                'placeholder' => 'Ingrese el tamaño del lote',
                'class' => 'uk-input'
            ),
            'options' => array(
                'label' => 'Tamaño',
            )
        ));
        
        $this->add(array(
            'name' => 'escrituras',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'escrituras',
                'class' => 'uk-select'
            ),
            'options' => array(
                'label' => 'Escrituras',
                'value_options' => [
                    '' => '',
                    'Si' => 'Si',
                    'No' => 'No'
                ],
            )
        ));
        
        $this->add(array(
            'name' => 'registroPropiedad',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'registroPropiedad',
                'class' => 'uk-select'
            ),
            'options' => array(
                'label' => 'Registro Propiedad',
                'value_options' => [
                    '' => '',
                    'Si' => 'Si',
                    'No' => 'No'
                ],
            )
        ));
        
        $this->add(array(
            'name' => 'vendido',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'vendido',
                'class' => 'uk-select'
            ),
            'options' => array(
                'label' => 'Vendido',
                'value_options' => [
                    'Si' => 'Si',
                    'Libre' => 'Libre',
                    'En proceso' => 'En proceso'
                ],
            )
        ));
        
        $this->add(array(
            'name' => 'precio',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'precio',
                'placeholder' => 'Ingrese el precio de venta',
                'required' => 'required',
                'class' => 'uk-input'
            ),
            'options' => array(
                'label' => 'Precio',
                'label_attributes' => array(
                    'class' => ''
                )
            )
        ));               
        
        $this->add(array(
            'name' => 'inicial',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'inicial',
                'placeholder' => 'Ingrese el inicial, si no hubiera ingrese 0',
                'required' => 'required',
                'class' => 'uk-input'
            ),
            'options' => array(
                'label' => 'Inicial',
                'label_attributes' => array(
                    'class' => ''
                )
            )
        ));
        
        $this->add(
			array(
				'name' => 'fechaVenta',
				'type' => 'Zend\Form\Element\Date',
				'attributes' => array(
					'id' => 'fechaVenta',
					'min'  => "2010-01-01",
                    'max'  => "2020-12-30",
                    'step' => '1', // days; default step interval is 1 day
					'class' => 'uk-input datepicker',
				),
				'options' => array(
				    'format' => 'Y-m-d',
					'label' => 'Fecha de venta',
					'label_attributes' => array(
						'class' => ''
					),
				),
			)
    	);
        
        $this->add(array(
            'name' => 'cuotas',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'cuotas',
                'class' => 'uk-select'
            ),
            'options' => array(
                'label' => 'Seleccione el número de cuotas',
                'value_options' => [
                    '0' => '0',
                    '3' => '3',
                    '6' => '6',
                    '9' => '9',
                    '12' => '12',
                    '18' => '18',
                    '24' => '24',
                    '30' => '30',
                    '36' => '36',
                ],
                'label_attributes' => array(
                    'class' => ''
                )
            )
        ));
        
        $this->add(array(
            'name' => 'montoPagar',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'inicial',
                'placeholder' => 'Ingrese el monto de la cuota mensual',
                'class' => 'uk-input'
            ),
            'options' => array(
                'label' => 'Monto de Cuota',
                'label_attributes' => array(
                    'class' => ''
                )
            )
        ));
        
        $this->add(array(
            'name' => 'cordenadas',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'cordenadas',
                'placeholder' => 'Ingrese las cordenadas',
                'class' => 'uk-input',
                'value' => '{"lat": 0.040472, "lng": -78.1476487}'
            ),
            'options' => array(
                'label' => 'Cordenadas'
            )
        ));
        
        $this->add(array(
            'name' => 'cedulaComprador',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'cedulaComprador',
                'placeholder' => 'Ingrese la cédula del comprador',
                'class' => 'uk-input'
            ),
            'options' => array(
                'label' => 'Cédula',
                'label_attributes' => array(
                    'class' => ''
                )
            )
        ));
        
        $this->add(array(
            'name' => 'nombresComprador',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'nombresComprador',
                'placeholder' => 'Ingrese nombres del comprador',
                'class' => 'uk-input'
            ),
            'options' => array(
                'label' => 'Nombres',
                'label_attributes' => array(
                    'class' => ''
                )
            )
        ));
        
        $this->add(array(
            'name' => 'apellidosComprador',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'apellidosComprador',
                'placeholder' => 'Ingrese apellidos del comprador',
                'class' => 'uk-input'
            ),
            'options' => array(
                'label' => 'Apellidos',
                'label_attributes' => array(
                    'class' => ''
                )
            )
        ));
        
        $this->add(array(
            'name' => 'telefonoComprador',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'telefonoComprador',
                'placeholder' => 'Ingrese teléfono del comprador',
                'class' => 'uk-input'
            ),
            'options' => array(
                'label' => 'Teléfono',
                'label_attributes' => array(
                    'class' => ''
                )
            )
        ));
        
        $this->add(array(
            'name' => 'boton',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Enviar',
                'class' => 'uk-button uk-button-primary',
                'id' => 'boton'
            )
        ));
    }
}