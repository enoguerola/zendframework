<?php

class Application_Model_DbTable_Operacio extends Zend_Db_Table_Abstract
{
    protected $_name = 'historial';
    
    public function getOperacionsbyProj($empid)
    {
        $operacions=$this->select()->from("historial")->where("id_proj=".$empid);
        $result=$operacions->query()->fetchAll();
        return $result;
    }
    
    public function getOperacionsbyEmp($empid)
    {
        $operacions=$this->select()->from("historial")->where("id_emp=".$empid);
        $result=$operacions->query()->fetchAll();
        return $result;
    }
    public function getUltimaOperacioByEmp($idemp)
    {
        $operacions=$this->select()->from("historial",array())->columns(array('data_hora','operacio','es_canvi','id_proj','id_tasca','data_inici','data_fi'))->where(" data_hora=(SElect max(data_hora) from historial where id_emp=".$idemp.")");
        $result=$operacions->query()->fetchAll();
        return $result;
    }
    public function addEntrada($idemp,$idProj,$idtasca)
    {
       
        $data=array("id_emp"=>$idemp,"id_proj"=>$idProj,"id_tasca"=>$idtasca,"operacio"=>"entrada","data_inici"=>date("Y-m-d h:i:s"));
        var_dump($data);
        
        $this->insert($data);
        //exit;
    }
    public function addCanvi($idemp,$idProjvell,$idtascavell,$idprojnou,$idtascanou)
    {
        $this->addSortida($idemp, $idProjvell, $idtascavell);
        $this->addEntrada($idemp, $idprojnou, $idtascanou);
        
    }
    public function addSortida($idemp,$idProj,$idtasca)
    {
        
        $data=array("operacio"=>"sortida","data_fi"=>date("Y-m-d h:i:s"));
        $this->update($data,"id_emp=".$idemp." and id_proj=".$idProj." and id_tasca=".$idtasca," and data_fi is null");
        //exit;
    }
    
    
}
?>
