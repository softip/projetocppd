<?php

if (!defined('BASEPATH'))
    exit('Acesso não permitido');

class Menu extends CI_Controller {

    private $contador = 0;

    function __construct() {
        parent::__construct();
//        $this->load->helper('acesso');
    }

    function index() {
        $this->crud = new grocery_CRUD();
        $this->crud->set_table('menu');
        $this->crud->set_subject("Menu");
        $this->crud->required_fields('categoria');
        $state = $this->crud->getState();
        if ($state == "insert_validation") {
            $this->crud->set_rules('categoria', 'Categoria', 'required|is_unique[menu.categoria]');
        }
        $this->crud->unset_clone();
        $this->crud->callback_before_delete(array($this, 'check_controllers_in_menu'));
        $form = $this->crud->render();
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Menu");
        $this->template->set("titulo", "Cadastro de Menu");
        $this->template->load('template/restrito', "crud/index", $form);
    }
    
    public function check_controllers_in_menu($primary_key) {
        $this->db->where('menu_idmenu', $primary_key);
        $usuarios = $this->db->get('controller');

        if ($usuarios->num_rows() > 0){                                    
            $this->crud->set_lang_string('delete_error_message', 'É necessário excluir todos os recursos antes de excluir um Menu');
            return false;
        }        
        return true;
    }

}
