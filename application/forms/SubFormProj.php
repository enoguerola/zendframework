<?php
class Application_Form_SubFormProj extends Zend_Form_SubForm
{
    public function __construct($projectes,$options=null) {
        parent::__construct($options);
        
        $arrayprojectes=new Zend_Form_Element_Select("projects");
        $arrayprojectes->setLabel("Projecte");
        $arrayprojectes->setRequired();
        $arrayprojectes->setDecorators($this->elementDecor);
       
        $arrayForSel=array();
        for ($i=0 ;$i<count($projectes);$i++)
        {
            $arrayForSel[$projectes[$i]['id']]=$projectes[$i]['nom'];
        }
       // var_dump($arrayForSel);
        $arrayprojectes->addMultiOption( '-1',"selecciona");
        $arrayprojectes->addMultiOptions($arrayForSel);
        
        $arrayprojectes->addValidator('inArray',false,array(array_keys($arrayForSel)));
       
        
  //      $this->setAttrib("id", "subformproj");
        
  
        $this->addElement($arrayprojectes);
        
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
                array('HtmlTag', array('tag' => 'div','class'=>'cont-element-proj')),
                'Form',
            ));
        }
        

}
?>
