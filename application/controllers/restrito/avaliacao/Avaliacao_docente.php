<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Avaliacao_docente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->usuario = (object) $this->session->userdata('user'); 
        $this->load->model("carreira_model", "carreira");
        $this->template->set("titulo", "Avaliação Docente");
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

    public function index($idrequerimento = null) {
        if( in_array($this->crud->getState(),["list", "success","ajax_list", "read"]) ){
            $this->crud->set_relation("servidor_idservidor", "servidor", "nome");
            $this->crud->set_relation("carreira_idcarreira", "carreira", "{classe}/{nivel}");
            $this->crud->columns("servidor_idservidor", "carreira_idcarreira", "numero_processo", "data_abertura" );
            $this->crud->display_as("numero_processo", "Número do Processo");
         }else if(in_array($this->crud->getState(),["edit", "update", "upload_file", "update_validation"])) {
             $this->crud->field_type("data_abertura", "readonly");
             $this->crud->field_type("numero_processo", "readonly");
             $this->crud->field_type("status", "readonly");
             $this->crud->set_field_upload("avaliacao_docente");
            $this->crud->fields("numero_processo", "data_abertura", "status","avaliacao_docente","carreira_idcarreira", "servidor_idservidor", "Requerimento_idRequerimento");            
            $idcarreira =  $this->carreira->getIdCarreira($idrequerimento);
            $this->crud->field_type("Requerimento_idRequerimento", "hidden", $idrequerimento);
            $this->crud->field_type("carreira_idcarreira", "hidden", $idcarreira);
            $this->crud->field_type("servidor_idservidor", "hidden", $this->usuario->idservidor);                       
         }               
        $form = $this->crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
    }

}
