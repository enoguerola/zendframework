<?php
class Application_Form_SubFormTasks extends Zend_Form_SubForm
{
     public function __construct($taskes,$options=null) {
        parent::__construct($options);
        
        $arrayprojectes=new Zend_Form_Element_Select("tasca");
        $arrayprojectes->setLabel("Tasques del projecte");
        //$arrayprojectes->setRequired(); 
        //$this->setMethod("GET");
        $arrayprojectes->setDecorators($this->elementDecor);
        //var_dump($options);
        $arrayForSel=array();
        for ($i=0 ;$i<count($taskes);$i++)
        {
            $arrayForSel[$taskes[$i]['id_tasca']]=$taskes[$i]['nom'];
        }
        //var_dump($arrayForSel);
        $arrayprojectes->addMultiOption( '-1',"selecciona");
        $arrayprojectes->addMultiOptions($arrayForSel);
        $this->setAttrib("id", "subformtasques");
        $arrayprojectes->addValidator('inArray',false,array(array_keys($arrayForSel)));
        $reset=new Zend_Form_Element_Reset("Reset");
       $reset->setAttrib("onclick", "habilitar()");
        $reset->setDecorators($this->submitDecor);
        
        
        $this->addElements(array($arrayprojectes,$reset));
    }
      public $submitDecor=array('ViewHelper',
            array(array('data'=>'HtmlTag'),array('tag'=>'div','class'=>'element-submit-task')),
            
            array(array('row'=>'HtmlTag'),array('tag'=>'div','class'=>'element-row-submit-task'))
        );
     public $elementDecor=array(
            'ViewHelper',
           'Errors',
            array(array('data'=>'HtmlTag'),array('tag'=>'div','class'=>'element-select-task')),
            array('Label',array('tag'=>'div','class'=>"label")),
            array(array('row'=>'HtmlTag'),array('tag'=>'div','class'=>'element-row-select-task')),
        );
        
        
       public function loadDefaultDecorators()
        {
            $this->setDecorators(array(
                'FormElements',
                array('HtmlTag', array('tag' => 'div','class'=>'cont-element')),
                'Form',
            ));
        }
        
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
