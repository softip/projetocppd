<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nivel extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->template->set("titulo", "Cadastro de Niveis");
		$this->template->set("breadcrumb1", "Cadastros");
		$this->template->set("breadcrumb2", "Niveis");
	}

	public function index()
	{
		$crud = new Grocery_CRUD();
		$crud->set_table("nivel");	
        $crud->display_as("classe_idclasse", "Classe");
        $crud->set_relation("classe_idclasse", "classe", "classe");
		$form = $crud->render();
		$this->template->load("template/restrito",'crud/index', $form);
	}

}
