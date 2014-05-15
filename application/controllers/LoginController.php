<?php
class LoginController extends Zend_Controller_Action
{
    public function init() {
        parent::init();
        echo $this->view->headScript()->appendFile($this->view->baseUrl()."/js/scriptsubform.js");
    }
    protected function indexAction()
    {
        $form=new Application_Form_FLoginSubforms();
        $formLogin=new Application_Form_SubFormLogin();
        
    
        $auth=  Zend_Auth::getInstance();
   
        if(!$auth->hasIdentity())
        {
            $form->addSubForm($formLogin, 'SubFormLogin');
            $form->setAttrib("id", "formloginSimple");
        }
        else
        {
            $form->setAttrib("id", "");
   //si eestic loguejat agafo la ultima ooperacio feta
            //i monto aarray
            $user=$auth->getIdentity();
            $modelOper=new Application_Model_DbTable_Operacio();
            $ultmaoper=$modelOper->getUltimaOperacioByEmp($user->id);
           var_dump($ultmaoper);
           //exit;
            $arrayOper=array();
            if(isset($ultmaoper[0]) && $ultmaoper[0]['operacio']!="sortida")
            {
                if($ultmaoper[0]['es_canvi']!=null)
                {
                    $arrayOper=array("canvi"=>"Canvi de tasca","sortida"=>"Sortida");
                }
                else if($ultmaoper[0]['operacio']=="entrada" && $ultmaoper[0]['es_canvi']==null)
                {
                    $arrayOper=array("sortida"=>"Sortida ","canvi"=>"Canvi de tasca");
                }
            }
            else 
            {
                $arrayOper=array("entrada"=>"Entrar"); 
            }
            
            
            $form->addSubForm(new Application_Form_SubFormOper($arrayOper), 'operacio');
        }
        if($this->getRequest()->isPost())
        {   
            if($form->isValid($_POST))
            {
                $FormData=$form->getValues();
               
                if(isset($FormData["SubFormLogin"]))
                {
                    var_dump($_POST);
                    $reult=LoginController::_process($formLogin->getValues());
               
                    if($reult[0]==true)
                    {
                        $this->_redirect("/login");
                    }
                    else
                    {
                        $this->view->errorLogin="No s'ha trobat cap coincidencia d'usuari";
                    }
                }
                else
                {
                  
                    $operacio=$FormData['operacio']['operacio'];
                    if($operacio=="entrada" || $operacio=="canvi")
                    {
                        $formProj=new Application_Form_SubFormProj($this->getAllProjects());
                    
                        $form->getSubForm("operacio")->addSubForm($formProj, 'projects');
                        
                        
                        if(isset($_POST['operacio']['projects']) && $_POST['operacio']['projects']['projects']!="-1")
                        {
                         
                            $proj=$_POST['operacio']['projects']['projects'];
                         
                        
                            $form->getSubForm("operacio")->getSubForm('projects')->projects->setAttrib("onmouseover", "this.disabled=true");
                            $form->submit->setAttrib("style","margin-top:-35px;");
                            $formTasques=new Application_Form_SubFormTasks($this->getTasksByProjectId($proj));
                            
                            $form->getSubForm('operacio')->getSubForm('projects')->addSubForm($formTasques,'tasks');
                        
                                          date_default_timezone_set("Europe/Paris");
                            if(isset($_POST['operacio']['projects']['tasks']) && $_POST['operacio']['projects']['tasks']['tasca']!="-1")
                            //if($form->getSubForm("projects")->getSubForm("tasks")->isValid($_POST))
                            {
                            
                                $tasca= $_POST['operacio']['projects']['tasks']['tasca'];
                                
                                $proj= $_POST['operacio']['projects']['projects'];
                           
                                echo "tasca sel: ".$tasca." proj ::".$proj.date("Y-m-d H:m:s");
                               
                                if($operacio=="entrada")
                                {
                                
                                    $modelOper=new Application_Model_DbTable_Operacio();
                               
                                   $modelOper->addEntrada($user->id,$proj,$tasca );
                                
                                }
                                else 
                                {
                              
                                    $modelOper=new Application_Model_DbTable_Operacio();
                                    $ultmaoper=$modelOper->getUltimaOperacioByEmp($user->id);
                                  
                              
                                   $modelOper->addCanvi($user->id, $ultmaoper[0]['id_proj'],$ultmaoper[0]['id_tasca'],$proj,$tasca);
                                    
            
                                }
                                $this->_redirect("login");
                                
                            }
                            else 
                            {
                                $form->populate($_POST);
                               
                            }

                            
                        }
                        
                     
                    }
                    else
                    {
                                     date_default_timezone_set("Europe/Paris");
                                    $modelOper=new Application_Model_DbTable_Operacio();
                                    $ultmaoper=$modelOper->getUltimaOperacioByEmp($user->id);
    
                                    $modelOper->addSortida($user->id,$ultmaoper[0]['id_proj'],$ultmaoper[0]['id_tasca']);
                        $this->_redirect("login");
                    }
              
                }
            }
        }
        
        
        $this->view->formLogin=$form;
        
    }
    public function getTasksByProjectId($idproj)
    {
      
        $ModelTask=new Application_Model_DbTable_Tasques();
        $selectTask=$ModelTask->select()->from("tasks")->where("id_proj=".$idproj);
        return $selectTask->query()->fetchAll();
    }
    public function  getAllProjects()
    {
       
        $ModelProj=new Application_Model_DbTable_Projects();
        $arrayproj=$ModelProj->select()->from("projects",array("id","nom"));
        return $arrayproj->query()->fetchAll();
    }
    public static function _getAuthAdapterAdmin()
    {
        $dbAdap=Zend_Db_Table::getDefaultAdapter();
        
            $authAdapter=new Zend_Auth_Adapter_DbTable($dbAdap);
                    $authAdapter->setTableName("users")
                        ->setIdentityColumn('username_dni')
                        ->setCredentialColumn('password')
                            
                        ->setCredentialTreatment('MD5(?)');
                    
                    return $authAdapter;
    }

    public static function _process($valores)
    {
        
        $adapter=self::_getAuthAdapterAdmin();
        
        $adapter->setIdentity($valores['SubFormLogin']['username'])
                ->setCredential($valores['SubFormLogin']['password']);
    //    var_dump($adapter);
        $auth= Zend_Auth::getInstance();
        $result=$auth->authenticate($adapter);
      echo " admin auth : ".var_dump($result);
        if($result->isValid())
        {
            $user=$adapter->getResultRowObject();
            
            $auth->getStorage()->write($user);
          
            return array(true,$user->role);
        }
        
        
        
        return array(false);
    }

    
    
}
?>
