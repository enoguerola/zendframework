<?php

class Zend_View_Helper_LoginForm extends Zend_View_Helper_Abstract
{
    public function LoginForm($Sessioact,$errors=null)
    {
        
        $result=$this->view->EnSessio();
        $string="";
        
        if($result[0]==true)
        {
            $string=$result[1];
        }
        else
        {   $errorclass="";
            if($errors!=null)
            {
                $errorclass="class='error'";
            }
            $string='<div id="loginform"  class="loginform" '.$errorclass.'>'.$Sessioact.'</div>';
        }

        return $string;
        
        
     
    }
}
?>
