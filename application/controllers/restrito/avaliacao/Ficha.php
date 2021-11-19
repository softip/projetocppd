<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ficha extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->template->set("titulo", "Cadastro de Fichas de Avaliação");
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Fichas");
    }

    public function index() {
        $crud = new Grocery_CRUD();
        $crud->set_table("ficha_avaliacao");
        $crud->set_subject("Ficha de avaliação");
        $crud->columns("nome", "tipo");
        $crud->set_relation_n_n("criterios", "ficha_criterios", "criterios_avaliativos", "ficha_avaliacao_idficha_avaliacao", "criterios_avaliativos_idcriterios_avaliativos", "criterio", "ordem");
        $crud->unset_clone();
        $form = $crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
    }

}
