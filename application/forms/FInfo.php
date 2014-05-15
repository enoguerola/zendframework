<?php
 class Application_Form_FInfo extends Zend_Form
 {
     public function __construct($listSel,$m,$options = null) {
         
        parent::__construct($options);
        $select= new Zend_Form_Element_Select("select");
         $arrayForSel=array();
        for ($i=0 ;$i<count($listSel);$i++)
        {
            $arrayForSel[$listSel[$i]['id']]=$listSel[$i]['nom'];
        }
        $select->addMultiOption("-1","Selecciona");
        $select->addMultiOptions($arrayForSel);
        //$select->setAttrib("onchange", "actualitzarInfo(".$m.")");
        $submit =new Zend_Form_Element_Submit("Enviar");
        $select->setAttrib("id", "enviar");
        $submit->setLabel("Enviar");
        
        $this->addElements(array($select));
        
        
     }
     
 }
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
