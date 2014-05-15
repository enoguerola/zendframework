<?php

class Application_Form_FEmpleat extends Zend_Form
{

    public function __construct($options = null) {
        parent::__construct($options);
        $this->addElementPrefixPath('', APPLICATION_PATH."/forms/validate/", 'validate');
        $id=new Zend_Form_Element_Hidden("id");
        
        $dni=new Zend_Form_Element_Text("dni");
          $dni->setLabel("DNI")->setFilters(array('StripTags','StringToUpper'))
                        ->setRequired()
                        ->clearValidators()
                        ->addValidator(new Form_Validate_Dni())
                        ->addValidator('NotEmpty',true,array("messages"=>"El dni es obligatori"))
                            ->addValidator('Db_NoRecordExists', true, array(
                'table' => 'users', 'field' => 'username_dni',
                'messages' => array(
                    Zend_Validate_Db_NoRecordExists::ERROR_RECORD_FOUND =>
                  "Ja exitsiex un empleat amb aquest dni '%value%'")));
          
            $dni->setDecorators($this->elementDecor);
            
            $password=new Zend_Form_Element_Password("password");
            $password->setValue("");
            $password->setLabel("Contrasenya")->addFilters(array('StripTags'))->setRequired();
            $password->setDecorators($this->elementDecor)->addValidator('NotEmpty',true,array("messages"=>"La contrasenya es obligatoria"));;
  
            $passwordConfirm=new Zend_Form_Element_Password("conf_password");
            
            $passwordConfirm->clearValidators()->addValidator(new Form_Validate_ConfirmPassword())->addFilters(array('StripTags'));
            $passwordConfirm->setDecorators($this->elementDecor)->addValidator('NotEmpty',true,array("messages"=>"Confirma el password és obligatori"));
            $passwordConfirm->setLabel("Confirma el password")->setRequired();
            $passwordConfirm->setValue("");
            
            
            $nom=new Zend_Form_Element_Text("nom");
            $nom->setLabel("Nom")->addFilters(array('StripTags'))->setRequired();         
            $nom->clearValidators()->addValidator('NotEmpty',true,array("messages"=>"El nom es obligatori"));
            
            $nom->setDecorators($this->elementDecor);
            
            $data_naix=new Zend_Form_Element_Text("data_naix");
            $data_naix->setAttrib("id", "datepicker");
            $data_naix->setLabel("Data de naiexment");
            $data_naix->setRequired()->setAttrib("readonly", "true");
            $data_naix->setDecorators($this->elementDecor);
            $data_naix->clearValidators()->addValidator('NotEmpty',true,array("messages"=>"La data de naixament es obligatoria"));
            
            $email=new Zend_Form_Element_Text("email");
            
            $email->setRequired()->setDecorators($this->elementDecor)->clearValidators()->setLabel("Email")
                    
                    ->addValidator('EmailAddress',true,array("messages"=>array(Zend_Validate_EmailAddress::INVALID_FORMAT=>"'%value%' es un emal no valid en el format local-part@hostname",
                                                                                Zend_Validate_EmailAddress::INVALID_HOSTNAME=>"'%value%' es un  nom de host no valid",  
                                                                               Zend_Validate_EmailAddress::INVALID_LOCAL_PART=>"'%value%' es un nom local no valid ",
                                                                               Zend_Validate_EmailAddress::INVALID_MX_RECORD=>"jjjj",
                                                                               Zend_Validate_EmailAddress::INVALID_SEGMENT=>"ddddddd",
                                                                               Zend_Validate_EmailAddress::INVALID=>"aaaaaaaa")));
            $email->addFilters(array('StripTags'));
            $sexe=new Zend_Form_Element_Radio("sexe");
            $sexe->setRequired()->setDecorators($this->elementDecor)->addMultiOptions(array("h"=>"Home","d"=>"Dona"))->setLabel("Sexe");;
            $sexe->clearValidators()->addValidator('NotEmpty',true,array("messages"=>"Genere es obligatori"));
            $this->setAttrib('enctype', 'multipart/form-data');
            $telefon=new Zend_Form_Element_Text("telf");
            $telefon->addFilter("StripTags")->addFilter("StringTrim")->setLabel("Telefon")->setDecorators($this->elementDecor)->setRequired()->clearValidators()
                    
                    ->addValidator('Digits',true,array("messages"=>array(Zend_Validate_Digits::NOT_DIGITS=>"'%value%' ha de contenir digits nomès",
                                                                            Zend_Validate_Digits::STRING_EMPTY=>"'Telefon es obligatori'")))
                    ->addValidator('NotEmpty',true,array("messages"=>"Telefon es obligatori"));
            
            $maxfilesize=new Zend_Form_Element_Hidden("maxsize");
            $maxfilesize-> setValue (204800);
            
            $file=new Zend_Form_Element_File("file");
            //$file->get
            $file->setLabel('Upload an image:')->setDestination("upload/");
            $file->clearValidators()
               -> setValidators (array (
                    array ( 'Count', false, 1),
                    array ( 'Size', false, 204800),
                    array ( 'Extension', false, 'jpg, gif, png'),
                    
                ))
               
                // -> setMaxFileSize (20000);
                -> setRequired (true);// ensure only 1 file
            $file->addValidator('Count', false, 1);
            // limit to 100K
            $file->addValidator('Size', false, 102400);
            // only JPEG, PNG, and GIFs
            $file->addValidator('Extension', false, 'jpg,png,gif');
            //$file->setMaxFileSize('102400KB');
            //$file->setDecorators($this->elementDecor);
            $file->removeDecorator('label');
            $file->removeDecorator('htmlTag');
            $file->addDecorators(array('File'));
            
            $submit=new Zend_Form_Element_Submit("Entrar");
            $submit->setLabel("Afegir empleat");
            $submit->setAttrib("name", "Entrar");

            $submit->setAttrib("id", "submitbutton");
            $submit->setDecorators($this->submitDecor);
        $this->addDisplayGroups(array(
                'left' => array(
                    'options'  => array('description' => ''),
                    'elements' => array($id,$dni, $password, $passwordConfirm,$nom,$data_naix),
                ),
                'right' => array(
                    'options'  => array('description' => ''),
                    'elements' => array($sexe, $email, $telefon,$file,$maxfilesize),
                ),
                'bottom' => array(
                    'elements' => array($submit),
                )
            ));
 
        $this->setDisplayGroupDecorators(array('Description', 'FormElements', 'Fieldset','File'));
            $this->setAttrib("id", "formEmpl");
            $this->addElements(array($id,$dni,$password,$passwordConfirm,$nom,$data_naix,$email,$sexe,$telefon,$maxfilesize,$file,$submit));
    
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
                array('HtmlTag', array('tag' => 'div','class'=>'cont-element-add-emp')),
                'Form',
            ));
        }

}