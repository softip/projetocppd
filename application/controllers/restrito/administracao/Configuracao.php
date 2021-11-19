<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracao extends CI_Controller{
        
    public function __construct() {
        parent::__construct();
        $usuario = $this->session->userdata("user");
        if (!isset($usuario)){
            redirect(site_url('restrito/login'));
        }
    }

    
    public function index(){        
        $crud = new Grocery_CRUD();
        $crud->set_table("configuracoes");        
        $crud->set_subject("Configurações");
        $crud->columns("titulo_termo");      
        $crud->display_as("titulo_termo", "Termo Licença");          
        $crud->unset_clone();
        $crud->unset_delete();
        $crud->unset_add();        
        $form = $crud->render();         
        $this->template->set("breadcrumb1", "Administração");
        $this->template->set("breadcrumb2", "Configurações");
        $this->template->set("titulo", "Configurações");
        $this->template->load('template/restrito', "crud/index", $form);
    }

}

