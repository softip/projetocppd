<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->template->set("titulo", "Cadastro de Setores Administrativos");
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Setor");
    }

    public function index($id = null) {        
        $crud = new Grocery_CRUD();
        if(is_numeric($id)){
            $crud->where("setor.setor_idsetor", $id);
            $crud->field_type("setor_idsetor", "hidden", $id);
        }else{
            $crud->field_type("setor_idsetor", "hidden");
            $crud->where("setor.setor_idsetor", null);
        }
        $crud->set_table("setor");
        $crud->set_subject("Setor");
        $crud->columns("nome", "servidor_idservidor");
        $crud->required_fields("nome", "servidor_idservidor");
        $crud->display_as("servidor_idservidor", "Chefe");
        $crud->set_relation("servidor_idservidor", "servidor", "nome");
        $crud->unset_read();
        $crud->unset_clone();
        $crud->add_action("Criar setor interno",null,site_url('restrito/rh/setor/index/'), "fas fa-house-user",null,null);
        $form = $crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
    }

   

}
