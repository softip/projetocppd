<?php

if (!defined('BASEPATH'))
    exit('Acesso não permitido');

class Privilegios extends CI_Controller {

    function __construct() {
        parent::__construct();
//        $this->load->helper('acesso');
    }

    function index() {
        $crud = new grocery_CRUD();
        $crud->set_table('privilegio');
        $crud->set_subject("Privilégio");

        $crud->required_fields('papel_idpapel', 'controller_idcontroller', 'permissao');

        $crud->display_as('controller_idcontroller', 'Recursos');
        $crud->display_as('papel_idpapel', 'Papel');
        $crud->display_as('acoes_idacoes', 'Action do Controller');
        $crud->display_as('permissao', 'Permissão');

        $crud->set_relation('controller_idcontroller', 'controller', 'name');
        $crud->set_relation('papel_idpapel', 'papel', 'papel');

        $crud->unset_clone();
        $form = $crud->render();
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Privilégio");
        $this->template->set("titulo", "Cadastro de Privilégios");
        $this->template->load('template/restrito', "crud/index", $form);
    }

}
