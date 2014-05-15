<?php

class Zend_View_Helper_SiteHeader extends Zend_View_Helper_Abstract
{
     public function SiteHeader($current)
     {
         
           $auth = Zend_Auth::getInstance();
           // Let's check the credential
            $registry = Zend_Registry::getInstance();
            
            $acl = $registry->get('acl');
            
            $identity = $auth->getIdentity();
            if ($auth->hasIdentity()) 
            {
                if($identity->role=="admin")    
                {
                    $menu="
                        <li class='active'><a href='".$this->view->url(array("controller"=>"admin","action"=>"admin"))."'><span>Administrador</span></a></li>
                        <li><a href='".$this->view->url(array("controller"=>"info","action"=>"index"))."'><span>Estadistiques</span></a></li>
                        <li><a href='".$this->view->url(array("controller"=>"login","action"=>"index"))."'><span>Login</span></a></li>";
                        

                }
                else
                {
                    $menu="
                        <li class='active'><a href='".$this->view->url(array("controller"=>"admin","action"=>"admin"))."'><span>Administrador</span></a></li>
                
                             <li><a href='".$this->view->url(array("controller"=>"info","action"=>"index"))."'><span>Info</span></a></li>
                             <li><a href='".$this->view->url(array("controller"=>"login","action"=>"index"))."'><span>Login</span></a></li>";
                }
            }
            else
            {
                $menu="
                        <li><a href='".$this->view->url(array("controller"=>"auth","action"=>"index"))."'><span>Administracio</span></a></li>
                             <li><a href='".$this->view->url(array("controller"=>"info","action"=>"index"))."'><span>Info</span></a></li>
                        <li><a href='".$this->view->url(array("controller"=>"login","action"=>"index"))."'><span>Login</span></a></li>";
            }
         return "<div id='header'>
             <div class='title_tagline'>
                <h1>Expo-exportacions</h1>
            </div>
             </div>
      <div id='menu'>
        <ul>  ".$menu."      </ul>
      </div>
      
    
   <div id='content'>";
     }
    
}
?>
