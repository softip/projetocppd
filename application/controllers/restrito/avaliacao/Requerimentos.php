<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requerimentos extends CI_Controller {

    public function __construct() {
        parent::__construct();        
        $this->template->set("titulo", "Requerimento de Progressão");
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Avaliação");
        $this->usuario = (object) $this->session->userdata('user');
        $this->load->model("carreira_model", "carreira");      
    }

    public function index() {    
        $crud = new Grocery_CRUD();
  
        $crud->set_table("requerimento");
        $crud->set_subject("Requerimento");  
        $crud->columns("servidor_idservidor","carreira_idcarreira","data", "status");
        $crud->display_as("carreira_idcarreira", "Classe/Nível");
        $crud->display_as("servidor_idservidor", "Servidor");
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_clone();
        $crud->unset_add();

        if( in_array($crud->getState(),["list", "success","ajax_list"]) ){
            $crud->set_relation("servidor_idservidor", "servidor", "nome");
            $crud->set_relation("carreira_idcarreira", "carreira", "{classe}/{nivel}");
        }

        $crud->callback_column("status", array($this, "_column_status"));

        $form = $crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
        
    }

    public function _column_status($value, $row){
        $status = $this->carreira->getStatus($row->carreira_idcarreira);
        if ($status === 'AGUARDANDO RECEBIMENTO PELO RH'){            
            return 
            '<a href="'.site_url("restrito/avaliacao/requerimentos/abrir_processo/$row->idRequerimento").'" class="btn btn-danger">Rejeitar Requerimento</a>' .
            '<a href="'.site_url("restrito/avaliacao/requerimentos/receber_requerimento/$row->idRequerimento").'" class="btn btn-success">Receber Requerimento</a>';            
        }else if($status === "AGUARDANDO ABERTURA DE PROCESSO"){
            return '<a href="'.site_url("restrito/avaliacao/requerimentos/abrir_processo/$row->idRequerimento").'" class="btn btn-success">Abrir Processo</a>';
        }else if($status === "AVALIAÇÃO INICIADA"){

        }
        return $status;
    }

    public function receber_requerimento($id){
        $this->db->where("idRequerimento", $id);
        $this->db->update("requerimento", array("status"=>"AGUARDANDO ABERTURA DE PROCESSO"));
        redirect(site_url("restrito/avaliacao/requerimentos"));
    }

    public function abrir_processo($id){
        redirect(site_url("restrito/avaliacao/processo/abrir/$id/add"));
    }
}
