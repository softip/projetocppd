<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Classe extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->template->set("titulo", "Cadastro de Classes");
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Classes");
    }

    public function index() {
        $crud = new Grocery_CRUD();
        $crud->set_table("classe");
        $form = $crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
    }

}
