<?php
class Application_Form_FTasques extends Zend_Form
{
    
    public function __construct($options = null) {
        parent::__construct($options);
        
        $nom =new Zend_Form_Element_Text("nom");
        $nom->setDecorators($this->elementDecor)->addFilter("StripTags")->setLabel("Nom")->setRequired()->clearValidators()
                ->addValidator('NotEmpty',true,array("messages"=>"El nom es obligatori"));
        
          $submit=new Zend_Form_Element_Submit("Entrar");
            $submit->setLabel("Afegir Tasca");
            $submit->setAttrib("name", "Entrar");

            $submit->setAttrib("id", "submitbutton");
            $submit->setDecorators($this->submitDecor);
        $this->addElements(array($nom,$submit));
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
