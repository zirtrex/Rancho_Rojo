<?php
namespace Application\Form\Filter;

use Zend\InputFilter\InputFilter;

class TerrenoFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'codTerreno',
            'required' => true
        ));
        
        $this->add(array(
            'name' => 'manzana',
            'required' => true
        ));
        
        $this->add(array(
            'name' => 'codigoLote',
            'required' => true
        ));
        
        $this->add(array(
            'name' => 'lote',
            'required' => true
        ));
        
        $this->add(array(
            'name' => 'nombre',
            'required' => true
        ));
        
        $this->add(array(
            'name' => 'tamanio',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
        ));
        
        $this->add(array(
            'name' => 'escrituras',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'registroPropiedad',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'precio',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'Float',
                    'options' => array(
                        'min' => 1,
                        'locale' => '<my_locale>',
                        'messages' => array(
                            \Zend\I18n\Validator\IsFloat::NOT_FLOAT => 'Por favor ingrese un valor numérico.',
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'inicial',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'Float',
                    'options' => array(
                        'min' => 0,
                        'locale' => '<my_locale>',
                        'messages' => array(
                            \Zend\I18n\Validator\IsFloat::NOT_FLOAT => 'Por favor ingrese un valor numérico.',
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'fechaVenta',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 200
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'cordenadas',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 45
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'nombresComprador',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 45
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'apellidosComprador',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 45
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'telefonoComprador',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 6,
                        'max' => 20
                    )
                )
            )
        ));
    }
}