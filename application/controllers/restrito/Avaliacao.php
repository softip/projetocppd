<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avaliacao extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->template->set("titulo", "Cadastro de Avaliações");
		$this->template->set("breadcrumb1", "Cadastros");
		$this->template->set("breadcrumb2", "Avaliações");
	}

    public function index()
	{
		$crud = new Grocery_CRUD();
		$crud->set_table("avaliacao");	
		$crud->display_as("carreira_idcarreira", "Carreira");
        $crud->set_relation("carreira_idcarreira", "carreira", "idcarreira");
		$form = $crud->render();
		$this->template->load("template/restrito",'crud/index', $form);
	}
}
