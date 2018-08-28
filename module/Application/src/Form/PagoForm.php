<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Hydrator\Reflection as ReflectionHydrator;
use Application\Entity\Pagos;

class PagoForm extends Form
{

    public function init()
    {
        parent::__construct('PagoForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
        
        $this->setHydrator(new ReflectionHydrator(false))->setObject(new Pagos());        
        
        $this->add(array(
            'name' => 'codPago',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'codPago'
            )
        ));
        
        $this->add([
            'name' => 'numeroCuota',
            'type' => 'Zend\Form\Element\Number',
            'attributes' => [
                'id' => 'numeroCuota',
                'class' => 'uk-input',
            ],
            'options' => [
                'label' => 'Número de cuota',
            ],
            
        ]);
        
        $this->add(
			array(
				'name' => 'fechaPago',
				'type' => 'Zend\Form\Element\Date',
				'attributes' => array(
					'id' => 'fechaPago',
					'min'  => "2010-01-01",
                    'max'  => "2020-12-30",
                    'step' => '1', // days; default step interval is 1 day
					'class' => 'uk-input datepicker',
				),
				'options' => array(
				    'format' => 'Y-m-d',
					'label' => 'Fecha de pago',
					'label_attributes' => array(
						'class' => ''
					),
				),
			)
    	);
        
        $this->add(array(
            'name' => 'formaPago',
            'type' => 'Zend\Form\Element\Radio',
            'attributes' => array(
                'id' => 'valor',
                'required' => 'required',
                'class' => 'uk-radio'
            ),
            'options' => array(
                'label' => 'Forma de Pago',
                'value_options' => [
                    'Cheque' => 'Cheque',
                    'Transferencia' => 'Transferencia',
                    'Tarjeta' => 'Tarjeta'
                ],
                'label_attributes' => array(
                    'class' => ''
                )
            )
        ));
        
        $this->add(array(
            'name' => 'valor',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'valor',
                'placeholder' => 'Ingrese el monto pagado',
                'required' => 'required',
                'class' => 'uk-input'
            ),
            'options' => array(
                'label' => 'Monto',
                'label_attributes' => array(
                    'class' => ''
                )
            )
        ));
        
        $this->add(array(
            'name' => 'comprobante',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
                'required' => 'required',
                'id' => 'comprobante',
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'codTerreno',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'codTerreno'
            )
        ));
        
        $this->add(array(
            'name' => 'codUsuario',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'codUsuario'
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