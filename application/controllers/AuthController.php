<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
    
   public function  indexAction()
   {
       $this->_forward("login");
   }

    public function loginAction()
    {
        $auth=  Zend_Auth::getInstance();
        if($auth->hasIdentity())
        {
                                $this->_helper->redirector("admin","admin");
        }
        
         $this->view->headScript()->appendFile($this->view->baseUrl()."/js/script.js"); 
         
         $form = new Application_Form_FLogin (); 
            $this->view->form=$form; 
            
        $request = $this -> getRequest (); 
        if ($request -> isPost ()) { 
            if ($form -> isValid ($request -> getPost ())) { 
                
                $result=  $this->_process($form->getValues());      
                        
                if ($result[0]==true) 
                { 
                       $sessio=new Zend_Session_Namespace("anterior");
                       if($sessio->controller=="auth")
                       {
                           $this->_helper->redirector($sessio->controller,$sessio->action);
                       }
                        else 
                            {
                                $this->_helper->redirector("admin","admin");
                            }
                      
                   
                }
                else {
                    
                $this->view->ErrorMessages="No exitseix cap usuari amb aquestes dades";
                $form->setOptions(array("id"=>"showformerrors"));
                }
            } 
            else 
            {
                $form->setOptions(array("id"=>"showformerrors"));
                
            }
            
        }        
    }

    protected function _getAuthAdapterUser()
    {
        $dbAdap=Zend_Db_Table::getDefaultAdapter();
        
            $authAdapter=new Zend_Auth_Adapter_DbTable($dbAdap);
                    $authAdapter->setTableName("users")
                        ->setIdentityColumn('username_dni')
                        ->setCredentialColumn('password')
                        ->setCredentialTreatment("MD5(?)");
                   
                    return $authAdapter;
    }

    public static function _getAuthAdapterAdmin()
    {
        $dbAdap=Zend_Db_Table::getDefaultAdapter();
        
            $authAdapter=new Zend_Auth_Adapter_DbTable($dbAdap);
                    $authAdapter->setTableName("users")
                        ->setIdentityColumn('username_dni')
                        ->setCredentialColumn('password')
                            
                        ->setCredentialTreatment('MD5(?) ');
                    
                    return $authAdapter;
    }

    public function _process($valores)
    {
        
        $adapter=self::_getAuthAdapterAdmin();
        
        $adapter->setIdentity($valores['username'])
                ->setCredential($valores['password']);
    //    var_dump($adapter);
        $auth= Zend_Auth::getInstance();
        $result=$auth->authenticate($adapter);
      //echo " admin auth : ".var_dump($result);
        //var_dump($result);
        if($result->isValid())
        {
            $user=$adapter->getResultRowObject();
            
            $auth->getStorage()->write($user);
          
            return array(true,$user->role);
        }
        
        
        
        return array(false);
    }

    public function logoutAction()
    {
        Zend_Auth :: getInstance ()-> clearIdentity (); 
        //$this->_forward('index');
        $this->_redirect("/auth");
    }


}



