<?php
class Application_Form_FProjecte extends Zend_Form
{
    
    public function __construct($options = null) {
        parent::__construct($options);
        $id=new Zend_Form_Element_Hidden("id");
        $nom =new Zend_Form_Element_Text("nom");
        $nom->setDecorators($this->elementDecor)->addFilter("StripTags")->setLabel("Nom")->setRequired()->clearValidators()
                ->addValidator('NotEmpty',true,array("messages"=>"El nom es obligatori"));
        
        
        $descripcio= new Zend_Form_Element_Textarea("descripcio");
        $descripcio->setRequired()->setDecorators($this->elementDecor)->addFilter("StripTags")
                ->addValidator('NotEmpty',true,array("messages"=>"La descripcio es obligatoria"));
        $descripcio->setLabel("Descripcio");
            $descripcio->setAttribs(array("cols"=>"25","rows"=>"20"));
        $submit=new Zend_Form_Element_Submit("Entrar");
            $submit->setLabel("Afegir projecte");
            $submit->setAttrib("name", "Entrar");

            $submit->setAttrib("id", "submitbutton");
            $submit->setDecorators($this->submitDecor);
        $this->addElements(array($id,$nom,$descripcio,$submit));
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
