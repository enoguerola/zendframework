<?php

class Application_Model_DbTable_Tasques extends Zend_Db_Table_Abstract
{

    protected $_name = 'tasks';
    
    public function addTask($nom,$idproj)
            {
        $total=count($this->fetchAll("id_proj=".$idproj));
        echo $total;
        $data=array("id_tasca"=>$total+1,"id_proj"=>$idproj,"nom"=>$nom);
        $this->insert($data);
    }
    
    public function getTasca($id,$idproj)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id_tasca = ' . $id." and id_proj=".$idproj);
        if (!$row){
                throw new Exception("Count not find row $id");
        }
        return $row->toArray();
    }
    public function deleteTasca($id,$idproj)
    {
        $this->delete("id_tasca=".$id."  and id_proj=".$idproj);
    }

}

