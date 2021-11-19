<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Curso extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $usuario = $this->session->userdata("user");
        if (!isset($usuario)) {
            redirect(site_url('restrito/login'));
        }
    }

    public function index() {
        $crud = new Grocery_CRUD();
        $crud->set_table("curso");
        $crud->set_subject("Cursos");
        $crud->columns("nome", "tipo");
        $crud->unset_clone();
        $form = $crud->render();
        //envio de dados para template
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Curso");
        $this->template->set("titulo", "Cadastro de Curso");
        $this->template->load('template/restrito', "crud/index", $form);
    }

}
