<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
    public function addUser($id,$dni,$password)
    {
        
        $data=array("id"=>$id,"username_dni"=>$dni,"password"=>md5($password),"role"=>"empleat");
        $this->insert($data);
    }
    
    public function deleteUser($id)
    {
        $this->delete("id=".$id);
    }
}

