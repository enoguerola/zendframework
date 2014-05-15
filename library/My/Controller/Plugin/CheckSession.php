<?php

class My_Controller_Plugin_CheckSession extends Zend_Controller_Plugin_Abstract
{/*
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {

       /* $auth = Zend_Auth::getInstance();
        //recuperes obj user en sesio
        // If user is not logged in and is not requesting login page
        // - redirect to login page.
        /*if (!$auth->hasIdentity()
                && $request->getControllerName() != $loginController
                && $request->getActionName()     != $loginAction) {

            $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
            $redirector->gotoSimpleAndExit($loginAction, $loginController);
        }

        // User is logged in or on login page.
        

        $sessio=new Zend_Session_Namespace("anterior");
        $sessio->control=$this->getRequest()->getControllerName();
        $sessio->action=$this->getRequest()->getActionName();
       if ($auth->hasIdentity()) {
            
// Is logged in
            // Let's check the credential
            $registry = Zend_Registry::getInstance();
            
            $acl = $registry->get('acl');
            
            $identity = $auth->getIdentity();
            
            // role is a column in the user table (database)
            $isAllowed = $acl->isAllowed($identity->role,
                                         $request->getControllerName(),
                                         $request->getActionName());
            
         
            if (!$isAllowed) {
              
                $request->setControllerName("auth");
                $request->setActionName("login");

              }
                else {
                    
                $request->setControllerName($request->getActionName());
                $request->setActionName($request->getActionName());

                }
        }
        else
        {
            
            $request->setControllerName("auth");
            $request->setActionName("login");
                
        }
  
    }*/
    
}
?>
