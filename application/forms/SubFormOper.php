<?php

class Application_Form_SubFormOper extends Zend_Form_SubForm
{
    
    public function __construct($operacions,$options = null) {
        parent::__construct($options);
        
        $operacio=new Zend_Form_Element_Select("operacio");
        
        $operacio->setMultiOptions($operacions);
        $operacio->setLabel("Operacio");
        $operacio->addValidator('inArray',false,array(array_keys($operacions)));
        $operacio->setDecorators($this->elementDecor);
        $this->addElement($operacio);
    }
          public $submitDecor=array('ViewHelper',
            array(array('data'=>'HtmlTag'),array('tag'=>'div','class'=>'element')),
          
            array(array('row'=>'HtmlTag'),array('tag'=>'div','class'=>'element-row'))
        );
     public $elementDecor=array(
            'ViewHelper',
           'Errors',
            array(array('data'=>'HtmlTag'),array('tag'=>'div','class'=>'element')),
            array('Label',array('tag'=>'div','class'=>"label")),
            array(array('row'=>'HtmlTag'),array('tag'=>'div','class'=>'element-row')),
        );
        
        
       public function loadDefaultDecorators()
        {
            $this->setDecorators(array(
                'FormElements',
                array('HtmlTag', array('tag' => 'div','class'=>'cont-element-oper')),
                'Form',
            ));
        }
        

    
}

?>