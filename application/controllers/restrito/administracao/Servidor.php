<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Servidor extends CI_Controller{
        
    public function __construct() {
        parent::__construct();
        $usuario = $this->session->userdata("user");
        if (!isset($usuario)){
            redirect(site_url('restrito/login'));
        }
    }

    
    public function index(){
        $crud = new Grocery_CRUD();
        $crud->set_table("servidor");
        $crud->columns("nome", "campi_idcampi", "email", "foto", "ativo");
        $crud->set_relation("campi_idcampi", "campi", "nome");
        $crud->set_relation("segmento_idsegmento", "segmento", "nome");        
        $crud->display_as("campi_idcampi", "Campi");        
        $crud->display_as("segmento_idsegmento", "Segmento");     
        $crud->set_field_upload("foto", "assets/uploads/user");
        
        $state = $crud->getState();
        if ($state == "insert_validation") {
            $crud->set_rules('matricula', 'Matrícula', 'required|is_unique[servidor.matricula]');
            $crud->set_rules('nome', 'Nome', 'required|is_unique[servidor.nome]');
            $crud->set_rules('email', 'email', 'required|is_unique[servidor.email]');
        }else if ($state == "edit") {
            $crud->field_type('matricula', 'readonly');
            $crud->field_type('nome', 'readonly');
           // $crud->field_type('email', 'readonly');
        }
        
        $crud->unset_clone();
        $crud->unset_delete();
        $form = $crud->render();
         //envio de dados para template
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Servidor");
        $this->template->set("titulo", "Cadastro de Servidor");
        $this->template->load('template/restrito', "crud/index", $form);
    }

}

