<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Avaliacao_chefia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->usuario = (object) $this->session->userdata('user'); 
        $this->load->model("carreira_model", "carreira");
        $this->template->set("titulo", "Avaliação Chefia Imediata");
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Avaliações");
        $this->crud = new Grocery_CRUD();        
        $this->crud->set_table("avaliacao");
        $this->crud->set_subject("Processos");
        $this->crud->display_as("carreira_idcarreira", "Carreira");
        $this->crud->display_as("servidor_idservidor", "Servidor");
        $this->crud->display_as("numero_processo", "Informe o Número do Processo");
        $this->crud->display_as("data_abertura", "Data de Abertura");
        $this->crud->display_as("data_homologacao", "Data de Homologação");
        $this->crud->display_as("avaliacao_discente", "Avaliação Discente");
        $this->crud->display_as("avaliacao_docente", "Avaliação Docente");
        $this->crud->display_as("avaliacao_chefia", "Avaliação da Chefia Imediata");
        $this->crud->display_as("Requerimento_idRequerimento", "Requerimento");
        $this->crud->unset_add();
        $this->crud->unset_delete();
    }

    public function index() {
        if( in_array($this->crud->getState(),["list", "success","ajax_list", "read"]) ){
            $this->crud->set_relation("servidor_idservidor", "servidor", "nome");
            $this->crud->set_relation("carreira_idcarreira", "carreira", "{classe}/{nivel}");
            $this->crud->columns("servidor_idservidor", "carreira_idcarreira", "numero_processo", "data_abertura", "status" );
            $this->crud->display_as("numero_processo", "Número do Processo");
            $this->crud->callback_column("status", array($this, "_column_status"));
         }else if(in_array($this->crud->getState(),["edit", "update", "upload_file", "update_validation"])) {
            $this->crud->field_type("data_abertura", "readonly");
            $this->crud->field_type("numero_processo", "readonly");
            $this->crud->field_type("status", "readonly");
            $this->crud->set_field_upload("avaliacao_chefia");
            $this->crud->fields("numero_processo", "data_abertura", "status","avaliacao_chefia");                       
         }  
         $this->crud->set_field_upload("avaliacao_chefia");          
        $this->crud->set_field_upload("avaliacao_docente"); 
        $this->crud->set_field_upload("avaliacao_discente");              
        $form = $this->crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
    }

    public function _column_status($value, $row){
        $status =  $this->carreira->getStatus($row->carreira_idcarreira);        
        $processo = $this->carreira->getProcessoAvaliacao($row->carreira_idcarreira);
        if($status === "AVALIAÇÃO INICIADA"){
            if (!empty($processo->avaliacao_chefia)){
                return "AVALIAÇÃO DA CHEFIA CONCLUÍDA";
            }else{
                return '<a href="'.site_url("restrito/avaliacao/avaliacao_chefia/index/edit/$row->idavaliacao").'" class="btn btn-success">Fazer Avaliação</a>';
            }            
        }
        return $status;
    }

}
