<?php

class InfoController extends Zend_Controller_Action
{

    public function init()
    {
          
        
    }

    public function indexAction()
    {
        
        $this->view->title="Estadistiques";
        
        
        $this->view->headTitle($this->view->title,"PREPEND");
    }
    public function listbyprojAction()
    {
        
        $this->view->title="Estadistiques per projecte";
        $this->view->headTitle($this->view->title,"PREPEND");
        $modelEmps=new Application_Model_DbTable_Projects();
        $select=$modelEmps->select()->from('projects',array("id","nom"));
       // var_dump($select->query()->fetchAll());
       $form=new Application_Form_FInfo($select->query()->fetchAll(),"byProj");
       $form->select->setLabel("Seleccionar un Projecte");
       $this->view->formEmp=$form;
       
       if($this->getRequest()->isPost())
       {
           if($form->isValid($_POST))
           {
               $modelOper=new Application_Model_DbTable_Operacio();
               echo $form->getValue('select');
               $list=new Zend_Session_Namespace("list");
               var_dump($modelOper->getOperacionsbyProj($form->getValue("select")));
               $list->llista=$modelOper->getOperacionsbyProj($form->getValue("select"));
               //$this->_redirect("/info/generatelist");
           }
       }
        
    }
    public function listbyempAction()
    {
        
        $this->view->title="Estadistiques per empleat";
        $this->view->headTitle($this->view->title,"PREPEND");
        $modelEmps=new Application_Model_DbTable_Empleats();
        $select=$modelEmps->select()->from('emps',array("id","nom"));
       // var_dump($select->query()->fetchAll());
       $form=new Application_Form_FInfo($select->query()->fetchAll(),"byemp");
       $form->select->setLabel("Seleccionar un Empleat");
       $this->view->formEmp=$form;
       $form->setAction("");
        
    }
    public function generatelistAction()
    {
        $this->view->title="Resultat d'estadistiques";
        $this->view->headTitle($this->view->title,"PREPEND");
        $page = $this->_getParam('page', 1);  
    // número de registros a mostrar por página  
    $registros_pagina = 5;  
    // número máximo de páginas a mostrar en el paginador  
    $rango_paginas = 2;  
    $emp=$this->_getParam("emp",-2);
    $proj=$this->_getParam("proj",-2);
    $modelOper=new Application_Model_DbTable_Operacio();
    if($emp>-2)
    {
        $operacions=$modelOper->getOperacionsbyEmp($emp);
    }
    else if($proj>-2)
    {
        $operacions=$modelOper->getOperacionsbyProj($proj);
    }
      
    
    
  
    $paginador = Zend_Paginator::factory($operacions);  
    $paginador->setItemCountPerPage($registros_pagina)  
              ->setCurrentPageNumber($page)  
              ->setPageRange($rango_paginas);  
  
    $param='<div id="view-list-info">';
                 if (count($paginador)){

                $param.= '<table>  
                <tr>  
                    <th>Operacio</th>  
                </tr>'; 
                 $i=0; foreach($paginador as $producto){ 
                    if($i%2==0)
                        {
                            $class="class='row-dif'";
                        }
                        else
                        {
                            $class="";
                        }
                        if($emp>-1)
                        {
                         
                $param.='<tr'.$class  .'> 
                    
                    <td>Ha estat treballant   en el projecte '.$producto['id_proj'].' en la tasca'.$producto['id_tasca'].' desde '.$producto['data_hora'].' fins '.$producto['data_fi'].'</td>  

                </tr>';     
                        }
                        else
                        {
                $param.='<tr'.$class  .'> 
                    
                    <td>L\'Empleat '.$producto['id_emp'].' ha treballat en la tasca '.$producto['id_tasca'].' desde '.$producto['data_hora'].' fins a '.$producto['data_fi'].'</td>  

                </tr>';  
                        }
               $i++;}
                $param.='</table>  
            </ul>';
                }
                else
                {
                    $param.="<h4>No hi ha cap registre</h4>";
                }
                $param.="</div>";
            echo $param;
            
            echo $this->view->paginationControl($paginador,
                                                'Jumping',
                                                'paginator.phtml'); 
            exit;
                                                
    }


}

