<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Carreira extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Carreiras");
        $this->load->model("carreira_model", "carreira");
    }

    public function index($id) {    
        $crud = new Grocery_CRUD();
        if(is_numeric($id)){
            $this->load->model('servidor_model', 'servidor');
            $servidor = $this->servidor->getNome($id);
            $this->template->set("titulo", "Progressões de $servidor->nome");
            $crud->where("servidor_idservidor", $id);
            $crud->field_type("servidor_idservidor", "hidden", $id);
        }
        $crud->set_table("carreira");
        $crud->set_subject("Progressões");
        $crud->columns("classe", "nivel", "data_progressao", "status");
        $crud->order_by("data_progressao", "desc");
        $crud->display_as("classe", "Classe");
        $crud->display_as("nivel", "Nível");
        $crud->display_as("data_progressao", "Data da Progressão");
        $crud->display_as("data_proxima", "Data prevista da próxima progressão");
        $crud->fields("classe", "nivel", "data_progressao", "servidor_idservidor");
        $crud->unset_read();
        $crud->unset_clone();

        $crud->callback_column("status", array($this, "_column_status"));               
        
        $form = $crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
    }

    public function _column_status($value, $row){
        return $this->carreira->getStatus($row->idcarreira);        
    }

}
