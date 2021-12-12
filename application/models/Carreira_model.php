<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Carreira_model extends CI_Model {
    
    public function getStatus($idcarreira){
        $this->db->where("idcarreira", $idcarreira);        
        $carreira = $this->db->get("carreira")->row();

        if ($processoConcluido = $this->isConcluidaAvaliacao($idcarreira)){ 
            if($processoConcluido->status == "HOMOLOGADO"){
                return "HOMOLOGADO";
            }
            return "AGUARDANDO HOMOLOGAÇÃO";            
        }

        if ($processo = $this->existeProcesso($idcarreira)){ 
            return $processo->status;            
        }

        if ($requerimento = $this->existRequerimento($idcarreira)){            
            return $requerimento->status;            
        }

        if ($this->hasMakeRequerimento($carreira)){
            return "APTO PARA REQUERIMENTO";
        }
    
        return $carreira->status;
    } 

    private function isConcluidaAvaliacao($idcarreira){
        $this->db->where("carreira_idcarreira", $idcarreira);
        $this->db->where(array("avaliacao_docente is not null"=> null));
        $this->db->where(array("avaliacao_discente is not null"=> null));
        $this->db->where(array("avaliacao_chefia is not null"=> null));
        return $this->db->get("avaliacao")->row();
    }

    private function existeProcesso($idcarreira){
        $this->db->where("carreira_idcarreira", $idcarreira);
        return $this->db->get("avaliacao")->row();
    }

    private function existRequerimento($idcarreira){
        $this->db->where("carreira_idcarreira", $idcarreira);
        return $this->db->get("requerimento")->row();         
    }

    private function hasMakeRequerimento($carreira){
        if ($carreira->status == 'Prevista'){
            return strtotime($carreira->data_progressao) < strtotime('now');          
        }  
        return false;     
    }

    public function getRequerimentoByCarreira($idcarreira){
        $this->db->where("carreira_idcarreira", $idcarreira);
        return $this->db->get("requerimento")->row();         
    }

    public function getProcessoAvaliacao($idcarreira){
        $this->db->where("carreira_idcarreira", $idcarreira);
        return $this->db->get("avaliacao")->row();
    }


    //return '<a href="" class="btn btn-danger">Aguardando o interstício</a>';
    //return '<a href="'.site_url('restrito/avaliacao/requerimento').'" class="btn btn-success">Fazer Requerimento</a>';
    public function setStatus($status, $idcarreira){

    } 


    public function getIdNextProgression($idservidor) {
        $this->db->join("requerimento", "requerimento.carreira_idcarreira = carreira.idcarreira", "left");
        $this->db->where("carreira.servidor_idservidor", $idservidor);
        $this->db->where("carreira.status", "Prevista");
        $this->db->where("idrequerimento", NULL);
        $carreira =  $this->db->get("carreira")->row();
        if($carreira){
            return $carreira->idcarreira;
        }
        return null;
    }

    public function getIdCarreira($idrequerimento){
        $this->db->select("carreira_idcarreira");
        $this->db->where("idRequerimento", $idrequerimento);
        $requerimento = $this->db->get("requerimento")->row();
        return $requerimento->carreira_idcarreira;
    }
}
