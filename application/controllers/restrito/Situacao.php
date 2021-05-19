<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Situacao extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->template->set("titulo", "Cadastro de Situação");
		$this->template->set("breadcrumb1", "Cadastros");
		$this->template->set("breadcrumb2", "Situação");
	}

	public function index()
	{
		$crud = new Grocery_CRUD();
		$crud->set_table("situacao");	
		$form = $crud->render();
		$this->template->load("template/restrito",'crud/index', $form);
	}

}
