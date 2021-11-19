<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chefe extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->template->set("titulo", "Cadastro de Chefes");
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Chefes");
    }

    public function index() {
        $crud = new Grocery_CRUD();
        $crud->set_table("chefe");
        $form = $crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
    }

}
