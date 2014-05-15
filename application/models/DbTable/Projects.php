<?php

class Application_Model_DbTable_Projects extends Zend_Db_Table_Abstract
{

    protected $_name = 'projects';
    
    public function addProject($nom,$desc)
            {
        $total=count($this->fetchAll());
        $data=array("id"=>$total+1,"nom"=>$nom,"descripcio"=>$desc);
        $this->insert($data);
    }
    public function getProject($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row){
                throw new Exception("Count not find row $id");
        }
        return $row->toArray();
    }
    public function updateProject($id,$nom,$desc)
    {
            $data=array("nom"=>$nom,"descripcio"=>$desc);
            $this->update($data, "id=".$id);
    }
    public function deleteProject($id)
    {
        $this->delete("id=".$id);
    }
    
}

