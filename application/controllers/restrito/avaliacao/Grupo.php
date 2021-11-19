<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grupo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->template->set("titulo", "Cadastro de Grupo");
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Grupo");
    }

    public function index() {
        $crud = new Grocery_CRUD();
        $crud->set_table("grupo");
        $crud->required_fields("nome", "descricao");
        $crud->display_as("descricao", "Descrição");
        $crud->add_action("Pontos", null, site_url("restrito/pontos/index/"), 'fas fa-plus-circle', null);
        $crud->set_relation_n_n('fichas', 'fichas_grupo', 'ficha_avaliacao', 'grupo_idgrupo', 'ficha_avaliacao_idficha_avaliacao', 'nome', 'ordem');
        $crud->unset_clone();
        $form = $crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
    }

}
