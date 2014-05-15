<?php
class Zend_View_Helper_EnSessio extends Zend_View_Helper_Abstract 
  { 
      public function EnSessio () 
      { 
            $auth = Zend_Auth :: getInstance (); 
            if ( $auth -> hasIdentity ()) { 

            $userid = $auth -> getIdentity ()->id ; 
            $username=new Application_Model_DbTable_Empleats();
            $reult=$username->select()->from("emps",array("nom","imatge"))->where("id=".$userid);
           
           
            $usernameauth=$reult->query()->fetch();
            
            $tipus=$auth->getIdentity()->role;
            $logoutUrl = $this -> view -> url (array( 'controller' => 'auth' , 
            'action' => 'logout' ), null , true ); 
                        return array(true,'<div class="sessio-act"><span>Benvingut ' . $usernameauth['nom'] . '.</span><span >Tipus de sessio: '.$tipus.' </span><img src="'.$this->view->baseUrl()."/".$usernameauth['imatge'].'"/> <a href="' . $logoutUrl . '"><div class="logout"></div></a></div>') ; 
                    } 

            $request = Zend_Controller_Front :: getInstance ()-> getRequest (); 
            $controller = $request -> getControllerName (); 
            $action = $request -> getActionName (); 
                    if( $controller == 'auth' && $action == 'index' ) { 
                        return array(false,'' ); 
                    } 
            $loginUrl = $this -> view -> url (array( 'controller' => 'auth' , 'action' => 'index' )); 
                    return array(false,'<a href="' . $loginUrl . '">Login</a>' ); 
                } 
            } 

?>
