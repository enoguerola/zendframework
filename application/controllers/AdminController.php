<?php

class AdminController extends Zend_Controller_Action
{
    public function  indexAction()
    {
        $this->_forward("admin");
    }
    public function init()
    {
        
        $this->view->headLink()->prependStylesheet($this->view->baseUrl()."/css/jquery-ui-1.8.17.custom.css");
          $this->view->headScript()->appendFile($this->view->baseUrl()."/js/jquery-1.7.1.min.js"); 
            $this->view->headScript()->appendFile($this->view->baseUrl()."/js/jquery.ui.core.js");  
        $this->view->headScript()->appendFile($this->view->baseUrl()."/js/jquery-ui-1.8.17.custom.min.js");    
        
            $this->view->headScript()->appendFile($this->view->baseUrl()."/js/adminscript.js");
    }
    private function getActPage()
    {
        $sesio=new Zend_Session_Namespace("anterior");
        $sesio->controlador=$this->getRequest()->getControllerName();
        $sesio->action=$this->getRequest()->getActionName();
         $auth = Zend_Auth::getInstance();
           // Let's check the credential
            $registry = Zend_Registry::getInstance();
            
            $acl = $registry->get('acl');
            
            $identity = $auth->getIdentity();
            if ($auth->hasIdentity()) 
            {
                if(!$acl->isAllowed($identity->role,$this->getRequest()->getControllerName(),$this->getRequest()->getActionName()))
                {
               
                            $this->_redirect("auth/login");
                }
                                
            }
            else
            {
                $this->_redirect("auth/login");
            }
         
    }
    public function adminAction()
    {
        $this->view->title="Llistat d'empleats";
        $auth = Zend_Auth::getInstance();
            $identity = $auth->getIdentity();
            if ($auth->hasIdentity() && $identity->role=="empleat") 
            {
                $this->_redirect("admin/editempleat/id/".$identity->id);
            }
            else
            {
                $this->getActPage();
            }
        $ModelEmpleats=new Application_Model_DbTable_Empleats();
        $arrayObjEmps=$ModelEmpleats->fetchAll();
        $this->view->listEmpleats=$arrayObjEmps;
        
        
    }
    public function adminprojAction()
    {
        $this->view->title="Llistat de projectes";
        $ModelProjects=new Application_Model_DbTable_Projects();
        $arrayObjProj=$ModelProjects->fetchAll();
        $this->view->listProjects=$arrayObjProj;
    }

    public function errorAction()
    {
        
    }
    public function addempleatAction()
    {
        $this->getActPage();
        $this->view->title="Afegir Empleat";
        $this->view->headTitle($this->view->title,"PREPEND");
        
        $formEmp=new Application_Form_FEmpleat();
        $this->view->formEmp=$formEmp;
        if($this->getRequest()->isPost())
        {
            if($formEmp->isValid($this->getRequest()->getPost()))
            {
                
                $dni=$formEmp->getValue("dni");
                $password=$formEmp->getValue("password");
                $nom=$formEmp->getValue("nom");
                $data=$formEmp->getValue("data_naix");
                $email=$formEmp->getValue("email");
                $sexe=$formEmp->getValue("sexe");
                $telf=$formEmp->getValue("telf");
                
                 
                $location = $formEmp->file->getFileName();
                $var=$formEmp->file->getFileInfo();
               $nomfitxer=$dni." - ".time().
               
               $ext=end(explode(".",$location));
               
                $formEmp->file->receive();
               
                $dest=$var['file']["destination"]."/".$nomfitxer.".".$ext;
                   rename($location, $dest);
                   //el rename 
                $arrayFinsData=explode("/",$data);
                $finsData=date("Y-m-d",mktime(0,0,0,$arrayFinsData[1],$arrayFinsData[0],$arrayFinsData[2]));
                $modelEmpl=new Application_Model_DbTable_Empleats();
                $modelEmpl->addEmpleat($dni,$nom,$password,$telf,$finsData,$email,$sexe,$dest);
                $this->_redirect("admin");
            }
        } 
        
    }
    /*public function addempleatAction()
    {
        $this->getActPage();
        $this->view->title="Afegir Empleat";
        $this->view->headTitle($this->view->title,"PREPEND");
        
        $formEmp=new Application_Form_FEmpleat();
        $this->view->formEmp=$formEmp;
        if($this->getRequest()->isPost())
        {
            if($formEmp->isValid($this->getRequest()->getPost()))
            {
                
                $dni=$formEmp->getValue("dni");
                $password=$formEmp->getValue("password");
                $nom=$formEmp->getValue("nom");
                $data=$formEmp->getValue("data_naix");
                $email=$formEmp->getValue("email");
                $sexe=$formEmp->getValue("sexe");
                $telf=$formEmp->getValue("telf");
                
                 
                $location = $formEmp->file->getFileName();
                $var=$formEmp->file->getFileInfo();
               $nom=$dni;
               
               $ext=end(explode(".",$location));
               
                $formEmp->file->receive();
               
                $dest=$var['file']["destination"]."\\".$nom.".".$ext;
                   rename($location, $dest);
                   //el rename 
                $arrayFinsData=explode("/",$data);
                $finsData=date("Y-m-d",mktime(0,0,0,$arrayFinsData[1],$arrayFinsData[0],$arrayFinsData[2]));
                $modelEmpl=new Application_Model_DbTable_Empleats();
                $modelEmpl->addEmpleat($dni,$nom,$password,$telf,$finsData,$email,$sexe,$location);
                //$this->_forward("admin");
            }
        } 
        
    }
*/
    public function editempleatAction()
    {
        
        $this->getActPage();        
        
        $this->view->title="Editar Empleat";
        $this->view->headTitle($this->view->title,"PREPEND");
        
        $formEmp=new Application_Form_FEmpleat();
        $formEmp->getElement("dni")->setAttrib("readonly", "true");
       $formEmp->getElement("password")->getDecorator("row")->setOption("style","display:none");
       $formEmp->getElement("conf_password")->getDecorator("row")->setOption("style","display:none");
       $formEmp->removeElement("conf_password") ;
       $formEmp->removeElement("password");
       $formEmp->getElement("Entrar")->setLabel("Desar");
        $formEmp->getElement("dni")->removeValidator("Db_NoRecordExists");
        
        $this->view->formEmp=$formEmp;
        	if ($this->getRequest()->isPost()) {//Si se env�an los datos, los recuperamos del formulario
			$formData = $this->getRequest()->getPost();
			if ($formEmp->isValid($formData)) {//Validamos que los datos recibidos sean correctos
				//Asignamos los valores recuperados a variables    $dni=$formEmp->getValue("dni");
                                
                                $nom=$formEmp->getValue("nom");
                                $data=$formEmp->getValue("data_naix");
                                $email=$formEmp->getValue("email");
                                $sexe=$formEmp->getValue("sexe");
                                $telf=$formEmp->getValue("telf");
                           
                                $arrayFinsData=explode("/",$data);
                              
                                if(count($arrayFinsData)>1)
                                {
                                    $arrayFinsData=date("Y-m-d",mktime(0,0,0,$arrayFinsData[1],$arrayFinsData[0],$arrayFinsData[2]));
                                }
                                else
                                {
                                    $arrayFinsData=$arrayFinsData[0];
                                }
                                
                                $location = $formEmp->file->getFileName();
                                $var=$formEmp->file->getFileInfo();
                            $nomfitxer=$dni." - ".time().

                            $ext=end(explode(".",$location));

                                $formEmp->file->receive();

                                $dest=$var['file']["destination"]."/".$nomfitxer.".".$ext;
                                rename($location, $dest);

                                $modelEmpl=new Application_Model_DbTable_Empleats();
                                $modelEmpl->updateEmpleat($nom,$telf,$arrayFinsData,$email,$sexe,$formEmp->getValue("id"),$dest);
                                $this->_redirect("admin/admin");
			}else{//Si los datos del formulario, no son v�lidos, se muestra el formulario con los datos de nuevo.
				$formEmp->populate($formData);
			}
		}else{//Mostramos los datos del libro en caso de no haber enviado los datos al servidor para actualizar el libro
			$id = $this->_getParam('id', 0);
			if ($id > 0) {
				$ModelEmps= new Application_Model_DbTable_Empleats();
				$formEmp->populate($ModelEmps->getEmpleat($id));
			}
                        else
                        {
                            $this->_redirect("admin");
                        }
                }
    
    }

    public function deleteempleatAction()
    {
        $this->getActPage();
            	$this->view->title = "Borrar Empleat";
		$this->view->headTitle($this->view->titulo, 'PREPEND');
		if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Si') {
				$id = $this->getRequest()->getPost('id');
                            $ModelEmp = new Application_Model_DbTable_Empleats();
				$ModelEmp->deleteEmpleat($id);
			}
			$this->_redirect("admin");
		}else{
			$id = $this->_getParam('id', 0);
			$ModelEmp = new Application_Model_DbTable_Empleats();
			$this->view->emp = $ModelEmp->getEmpleat($id);
		}		
    }

    public function addprojecteAction()
    {
        $this->getActPage();
        
            	$this->view->title = "Afegir projecte";
		$this->view->headTitle($this->view->titulo, 'PREPEND');
        $formProj=new Application_Form_FProjecte();
        $this->view->formProj=$formProj;
        if($this->getRequest()->isPost())
        {
            if($formProj->isValid($this->getRequest()->getPost()))
            {
                
                $nom=$formProj->getValue("nom");
                $desc=$formProj->getValue("descripcio");
                
                $modelProj=new Application_Model_DbTable_Projects();
                $modelProj->addProject($nom,$desc);
                $this->_redirect("admin");
            }
        } 
        
    }

    public function editprojecteAction()
    {
        $this->getActPage();
       $formProj=new Application_Form_FProjecte();
       $formProj->getElement('Entrar')->setLabel("Guardar canvis");
       $this->view->formProj=$formProj;
       
            	$this->view->title = "Editar Projecte";
		$this->view->headTitle($this->view->titulo, 'PREPEND');
        $this->view->idproj= $this->_getParam('id');
      	if ($this->getRequest()->isPost()) {//Si se env�an los datos, los recuperamos del formulario
            $formData = $this->getRequest()->getPost();
            if ($formProj->isValid($formData)) {//Validamos que los datos recibidos sean correctos
                
                
               $nom=$formProj->getValue("nom");
                $desc=$formProj->getValue("descripcio");
                $modelProj=new Application_Model_DbTable_Projects();
                $modelProj->updateProject($formProj->getValue("id"),$nom,$desc);
                $this->_redirect("admin/adminproj");
		
                    //Asignamos los valores recuperados a variables    $dni=$formEmp->getValue("dni");
            } else {//Si los datos del formulario, no son v�lidos, se muestra el formulario con los datos de nuevo.
                $formProj->populate($formData);
            }
        } else {//Mostramos los datos del libro en caso de no haber enviado los datos al servidor para actualizar el libro
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $ModelProj = new Application_Model_DbTable_Projects();
                $formProj->populate($ModelProj->getProject($id));
            } else {
                $this->_redirect("admin");
            }
        
        }
    
    }

    public function deleteprojecteAction()
    {
        $this->getActPage();
    	$this->view->title = "Borrar Projecte";
		$this->view->headTitle($this->view->titulo, 'PREPEND');
		if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Si') {
				$id = $this->getRequest()->getPost('id');
                            $ModelProj = new Application_Model_DbTable_Projects();
				$ModelProj->deleteProject($id);
			}
			$this->_redirect("admin/adminproj");
		}else{
			$id = $this->_getParam('id', 0);
			$ModelProj = new Application_Model_DbTable_Projects();
			$this->view->proj = $ModelProj->getProject($id);
		}		
    }

    public function taskgestioAction()
    {
        $this->getActPage();
        if ($this->_getParam('idproj') != null) {
            $modelproj=new Application_Model_DbTable_Projects();
            $proj=$modelproj->getProject($this->_getParam('idproj'));
           
            $this->view->title = "Gestio de taques del projecte: ".$proj['nom'];
		$this->view->headTitle($this->view->titulo, 'PREPEND');
	
            $modeltaks = new Application_Model_DbTable_Tasques();
            $this->view->tasks = $modeltaks->fetchAll("id_proj=" . $this->_getParam('idproj'));
            $this->view->idproj=$this->_getParam('idproj');
            $formtask = new Application_Form_FTasques();
            $this->view->formTask = $formtask;
            if ($this->getRequest()->isPost()) {
                if ($formtask->isValid($this->getRequest()->getPost())) {

                    $nom = $formtask->getValue("nom");
                    $modelTask = new Application_Model_DbTable_Tasques();
                    $modelTask->addTask($nom, $this->_getParam("idproj"));
                    $this->_redirect("admin/editprojecte");
                } else {
                    
                }
            }
        } else {
            $this->_redirect('admin/editprojecte');
        }
        
    }

    public function deletetaskAction()
    {
        $this->getActPage();
        if ($this->_getParam('idproj') != null) {
          
            $this->view->idproj=$this->_getParam('idproj');
        $modelproj=new Application_Model_DbTable_Projects();
            $proj=$modelproj->getProject($this->_getParam('idproj'));
           
            
	
        $this->view->title = "Borrar Tasca del projecte: ".$proj['nom'];;
		$this->view->headTitle($this->view->titulo, 'PREPEND');
		if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Si') {
				$id = $this->getRequest()->getPost('id_tasca');
                            $ModelProj = new Application_Model_DbTable_Tasques();
				$ModelProj->deleteTasca($id,$this->_getParam("idproj"));
			}
			$this->_redirect("admin/editprojecte");
		}else{
			$id = $this->_getParam('id_tasca');
			$ModelProj = new Application_Model_DbTable_Tasques();
			$this->view->task = $ModelProj->getTasca($id,$this->_getParam("idproj"));
		}		
        }
         else {
            $this->_redirect('admin/editprojecte');
        }
    }


}

















