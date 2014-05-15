<?php
class Application_Form_SubFormLogin extends Zend_Form_SubForm
{
    public function __construct($options=null)
    {
            parent::__construct($options);
        $this->addElementPrefixPath('', APPLICATION_PATH."/forms/validate/", 'validate');
      
        $username=new Zend_Form_Element_Text("username");
        $username->setLabel("DNI");
        
        $username->setRequired()->setFilters(array("StringTrim","StringToUpper"))
                ->clearValidators()
          ->addValidator(new Form_Validate_Dni())
        ->addValidator('NotEmpty',true,array("messages"=>"Usurai es obligatori"));
        
        $username->setDecorators($this->elementDecor);
        
        
        $password=new Zend_Form_Element_Password("password");
        $password->setLabel("Contrasenya");
        
        $password->setRequired()->setFilters(array("StringTrim","StripTags"))
                        ->clearValidators()
     //    ->addValidator('Alpha',false,array("messages"=>array('notAlpha'=>"Caracters no permesos",  Zend_Validate_Alpha::STRING_EMPTY=>"Valor buit")))
          ->addValidator('StringLength', false, 
                                                    array(3, 20,"messages"=>
                                                    array('stringLengthTooLong'=>"'%value%' és més llarg del permès (%max% caracters)",
                                                    'stringLengthTooShort'=>"'%value%' es mes petit de %min% caracters",
                                                    )))
        ->addValidator('NotEmpty',true,array("messages"=>"La contrasenya es obligatoria"));
        
        $password->setDecorators($this->elementDecor);
       
        $submit=new Zend_Form_Element_Submit("Entrar");
        $submit->setLabel("");
       $submit->setAttrib("name", "Entrar");
        
        $submit->setDecorators($this->submitDecor);
       
        $this->setAttrib("id", "subformlogin");
        $this->setName("subformlogin");
        $this->addElements(array($username,$password));
       
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
