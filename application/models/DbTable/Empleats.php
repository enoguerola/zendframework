<?php

class Application_Model_DbTable_Empleats extends Zend_Db_Table_Abstract
{

    protected $_name = 'emps';

    public function addEmpleat($dni,$nom,$password,$telf,$data,$email,$sexe,$location)
    {
        $total=count($this->fetchAll());
        $data=array("id"=>$total+1,"nom"=>$nom,"dni"=>$dni,"telf"=>$telf,"email"=>$email,"password"=>md5($password),"data_naix"=>$data,"sexe"=>$sexe,"imatge"=>$location);
        $this->insert($data);
        $ModelUsers=new Application_Model_DbTable_Users();
        $ModelUsers->addUser($total+1,$dni, $password);
    }
    public function getEmpleat($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row){
                throw new Exception("Count not find row $id");
        }
        return $row->toArray();
    }
    public function updateEmpleat($nom,$telf,$data,$email,$sexe,$id,$location)
    {
            $data=array("nom"=>$nom,"telf"=>$telf,"email"=>$email,"data_naix"=>$data,"sexe"=>$sexe,"imatge"=>$location);
            $this->update($data, "id=".$id);
    }
    public function deleteEmpleat($id)
    {
        $this->delete("id=".$id);
        $ModelUsers=new Application_Model_DbTable_Users();
        $ModelUsers->deleteUser($id);
        
    }
    
    
   
}

