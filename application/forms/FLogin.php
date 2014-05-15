<?php

class Application_Form_FLogin extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->addElementPrefixPath('', APPLICATION_PATH."/forms/validate/", 'validate');
        
        $username=new Zend_Form_Element_Text("username");
        $username->setLabel("DNI");
        $username->setRequired()->setFilters(array("StringTrim","StringToUpper"))
                ->clearValidators()
          ->addValidator(new Form_Validate_Dni())
        ->addValidator('NotEmpty',true,array("messages"=>"Usurai es obligatori"));
        
        $username->addDecorators($this->elementDecor);
        
        
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
        
        $password->addDecorators($this->elementDecor);
        
        $submit=new Zend_Form_Element_Submit("Entrar");
        $submit->setLabel("");
        $submit->setAttrib("name", "Entrar");
        
        $submit->setAttrib("id", "submitbutton");
        $submit->setDecorators($this->submitDecor);
       
        $this->setAttrib("id", "formlogin");
        
        $this->addElements(array($username,$password,$submit));
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

