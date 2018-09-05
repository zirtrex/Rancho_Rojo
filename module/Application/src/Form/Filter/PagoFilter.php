<?php
namespace Application\Form\Filter;

use Zend\InputFilter\InputFilter;

class PagoFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'numeroCuota',
            'required' => true
        ));
        
        $this->add(array(
            'name' => 'fechaPago',
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
            'name' => 'valor',
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
        
        $this->add([
            'type'     => 'Zend\InputFilter\FileInput',
            'name'     => 'comprobante',
            'required' => false,
            'validators' => [
                new \Zend\Validator\File\Size('2MB'),
                //new \Zend\Validator\File\Extension('csv'),
                //new \Zend\Validator\File\MimeType(array('application/vnd.ms-excel','enableHeaderCheck'=>true)),
            ],
            'filters'  => [
                [
                    'name' => 'FileRenameUpload',
                    'options' => [
                        'target' => './public/comprobantes',
                        'useUploadName' => true,
                        'useUploadExtension' => true,
                        'overwrite' => false,
                        'randomize' => true
                    ]
                ]
            ],
        ]);
        
        $this->add(array(
            'name' => 'codTerreno',
            'required' => true
        ));
        
        $this->add(array(
            'name' => 'codUsuario',
            'required' => true
        ));
    }
}