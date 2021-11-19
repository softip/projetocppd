<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Criterio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->template->set("titulo", "Cadastro de Critérios de avaliação");
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Critérios");
    }

    public function index() {
        $crud = new Grocery_CRUD();
        $crud->set_table("criterios_avaliativos");
        $crud->display_as("criterio", "Critério");
        $crud->required_fields("criterio");
        //$crud->unset_texteditor("criterio");
        $form = $crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
    }

}
