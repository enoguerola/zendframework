
<?php
class My_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    public function __construct() {
     
        $acl = new Zend_Acl();

        $roles  = array('admin', 'normal','empleat');

        // Controller script names. You have to add all of them if credential check
        // is global to your application.
        $actions = array('auth', 'index','admin','error');

        foreach ($roles as $role) {
            $acl->addRole(new Zend_Acl_Role($role));
        }
       
       
       
        foreach ($actions as $controller) {
            $acl->add(new Zend_Acl_Resource($controller));
        }
       
       
        // Here comes credential definiton for admin user.
        $acl->allow('admin'); // Has access to everything.

        // Here comes credential definition for normal user.
        $acl->allow('empleat'); // Has access to everything...
        $acl->deny('empleat', 'admin',"admin"); // ... except the admin controller.
        $acl->deny('empleat', 'admin',"add-empleat"); // ... except the admin controller.
        //$acl->deny('empleat',"error","error");
        $acl->deny('empleat','admin','deleteempleat');
        $acl->deny('empleat','admin','add-projecte');
        
        // Finally I store whole ACL definition to registry for use
        // in AuthPlugin plugin.
        Zend_Registry::set('acl', $acl);

    }
    
}
?>