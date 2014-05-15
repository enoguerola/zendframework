<?php
class Application_Form_FLoginSubforms extends Zend_Form
{
     public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName("contenidor");
        $SubFormLogin=new Application_Form_SubFormLogin();
        
//        $this->addSubForm($SubFormLogin,'SubFormLogin');
      
      
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel("");
        $submit->setDecorators($this->submitDecor);
        $submit->setAttrib("onclick", "habilitarSelect()");
        $submit->setAttrib('id', 'send-cont-subform')
               ->setOrder(10);
        $this->addElement($submit);
        
    }
      public $submitDecor=array('ViewHelper',
            array(array('data'=>'HtmlTag'),array('tag'=>'div','class'=>'element-content-send')),
          
            array(array('row'=>'HtmlTag'),array('tag'=>'div','class'=>'element-row-content-send'))
        );
         public function loadDefaultDecorators()
        {
            $this->setDecorators(array(
                'FormElements',
                array('HtmlTag', array('tag' => 'div','class'=>'cont-form')),
                'Form',
            ));
        }
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
