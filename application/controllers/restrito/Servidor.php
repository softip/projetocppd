<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servidor extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->template->set("titulo", "Cadastro de Servidores");
		$this->template->set("breadcrumb1", "Cadastros");
		$this->template->set("breadcrumb2", "Servidores");
	}

	public function index(){		
		$crud = new Grocery_CRUD();
		$crud->set_table("servidor");
		$crud->set_subject("Servidor");
		$crud->display_as("situacao_idsituacao", "Situação");
		$crud->set_relation("situacao_idsituacao", "situacao", "especificacao");
		$form = $crud->render();
		$this->template->load("template/restrito",'crud/index', $form);
	}
}
