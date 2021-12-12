<?php

if (!defined('BASEPATH'))
    exit('Acesso não permitido');

class Controller extends CI_Controller {

    private $contador = 0;

    function __construct() {
        parent::__construct();
//        $this->load->helper('acesso');
    }

    function index() {
        $crud = new grocery_CRUD();
        $crud->set_table('controller');
        $crud->set_subject("Recurso");
        $crud->required_fields('name', "titulo", "descricao", "gerenciar", "mostrar_menu", "icone");
        $crud->columns("descricao", "titulo", "menu_idmenu");
        $crud->set_relation("menu_idmenu", "menu", "categoria");
        $crud->display_as("menu_idmenu", "Menu");
        $crud->display_as("descricao", "Descrição");
        $crud->display_as("name", "Url");
        $state = $crud->getState();
        if ($state == "insert_validation") {
            $crud->set_rules('name', 'Nome', 'required|is_unique[controller.name]');
        }
        //$crud->unset_clone();
        $form = $crud->render();
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Recursos");
        $this->template->set("titulo", "Cadastro de Recursos");
        $this->template->load('template/restrito', "crud/index", $form);
    }
    
    

}
