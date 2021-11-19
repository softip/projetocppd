<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Campi extends CI_Controller{
    
    
    public function __construct() {
        parent::__construct();
        $usuario = $this->session->userdata("user");
        if (!isset($usuario)) {
            redirect(site_url('restrito/login'));
        }
    }

    
    public function index(){
        $crud = new Grocery_CRUD();
        $crud->set_table("campi");
        $crud->set_subject("Campi");
        $crud->columns("nome");
        $crud->unset_clone();
        $form = $crud->render();
         //envio de dados para template
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Campi");
        $this->template->set("titulo", "Cadastro de Campis");
        $this->template->load('template/restrito', "crud/index", $form);
    }

}