<?php
namespace Users\Form;

use Zend\Form\Form;
use Zend\Hydrator\Reflection as ReflectionHydrator;
use Application\Entity\Usuario;


class EditarUsuarioForm extends Form
{
    protected $selectTable;
    
    public function init()
    {        
        
    	parent:: __construct('EditarUsuarioForm');

        $this->setHydrator(new ReflectionHydrator(false))->setObject(new Usuario());

    	$this->setAttribute('method', 'post');
    	
    	$this->setAttributes(array(
    	    'class' => 'uk-form'
    	));
    	
    	$this->add(array(
    	    'name' => 'codUsuario',
    	    'type' => 'hidden',
    	    'attributes' => array(
    	        'id' => 'codUsuario'
    	    )
    	));
    	
    	$this->add(array(
    	    'name' => 'nombres',
    	    'type' => 'Zend\Form\Element\Text',
    	    'attributes' => array(
    	        'id' => 'nombres',
    	        'placeholder' => 'Ingrese nombre(s)',
    	        'required' => 'required',
    	        'class' => 'uk-input'
    	    ),
    	    'options' => array(
    	        'label' => 'Nombre(s)',
    	        'label_attributes' => array(
    	            'class' => 'uk-form-label'
    	        )
    	    )
    	));
    	
    	$this->add(array(
    	    'name' => 'primerApellido',
    	    'type' => 'Zend\Form\Element\Text',
    	    'attributes' => array(
    	        'id' => 'primerApellido',
    	        'placeholder' => 'Ingrese primer apellido',
    	        'required' => 'required',
    	        'class' => 'uk-input'
    	    ),
    	    'options' => array(
    	        'label' => 'Primer Apellido',
    	        'label_attributes' => array(
    	            'class' => 'uk-form-label'
    	        )
    	    )
    	));
    	
    	$this->add(array(
    	    'name' => 'segundoApellido',
    	    'type' => 'Zend\Form\Element\Text',
    	    'attributes' => array(
    	        'id' => 'segundoApellido',
    	        'placeholder' => 'Ingrese segundo apellido',
    	        'class' => 'uk-input'
    	    ),
    	    'options' => array(
    	        'label' => 'Segundo Apellido',
    	        'label_attributes' => array(
    	            'class' => 'uk-form-label'
    	        )
    	    )
    	));
    	
    	$this->add(array(
    			'name' => 'csrf',
    			'type' => 'Zend\Form\Element\Csrf'
    	));
    	
    	$this->add(
        		array(
        				'name' => 'guardar',
        				'type' => 'Zend\Form\Element\Submit',
        				'attributes' => array(
        						'value' => 'Editar datos',
        						'class' => 'uk-button uk-button-primary',
        				),
        		)
        );
    }  
}