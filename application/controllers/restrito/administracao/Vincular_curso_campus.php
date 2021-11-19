<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vincular_curso_campus extends CI_Controller{
    
    
    public function __construct() {
        parent::__construct();
        $this->usuario = $this->session->userdata("user");
        if (!isset($this->usuario)) {
            redirect(site_url('restrito/login'));
        }
        $this->crud = new Grocery_CRUD();
        $this->_auth($this->usuario);
    }

    public function _auth($usuario) {
         if ($usuario['nivel'] == 'Campus') {
            $this->_editDadosCampi();
            $this->crud->where("idcampi", $usuario['idcampi']);
        } 
    }
    
    protected function _editDadosCampi() {
        $idEdit = end($this->uri->segments);
        if (is_numeric($idEdit) &&  $idEdit != $this->usuario['idcampi']) {
            redirect(site_url("restrito/administracao/vincular_curso_campus"));
        }
    }
    
    public function index(){      
        $this->crud->set_table("campi");
        $this->crud->set_subject("Cursos do campus");
        $this->crud->columns("nome");        
        $this->crud->unset_clone();
        $this->crud->unset_add();
        $this->crud->unset_delete();
        $this->crud->set_relation_n_n("cursos", "campi_curso", 'curso', "campi_idcampi", "curso_idcurso", "{tipo} em {nome}", "ordem");
        
        $form = $this->crud->render();        
         //envio de dados para template
        $this->template->set("breadcrumb2", "Cadastros");
        $this->template->set("breadcrumb2", "Curso");
        $this->template->set("titulo", "Cadastro de Cursos");
        $this->template->load('template/restrito', "crud/index", $form);
    }

}