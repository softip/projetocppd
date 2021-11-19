<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pontos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->template->set("titulo", "Cadastro de Pontos");
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Pontos");
    }

    public function index($id) {
        if (!is_numeric($id)) {
            redirect(site_url("restrito/grupo"));
        }

        $crud = new Grocery_CRUD();
        $crud->set_table("fichas_grupo");
        $crud->set_subject("Pontação");
        $crud->display_as("ficha_avaliacao_idficha_avaliacao", "Ficha");
        $crud->columns("ficha_avaliacao_idficha_avaliacao", "pontos");
        $crud->fields("ficha_avaliacao_idficha_avaliacao", "pontos");
        $crud->set_relation("ficha_avaliacao_idficha_avaliacao", "ficha_avaliacao", "nome");
        $crud->where("grupo_idgrupo", $id);
        $crud->field_type("ficha_avaliacao_idficha_avaliacao", "readonly");

        $crud->unset_clone();
        $crud->unset_add();
        $crud->unset_delete();
        $crud->unset_read();
        $form = $crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
    }

}
