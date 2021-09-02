<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servidor extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//adicionar essa linha para controlar acesso ao controlador
		$this->load->library("controla_acesso");
		
		$this->template->set("titulo", "Cadastro de Servidores");
		$this->template->set("breadcrumb1", "Cadastros");
		$this->template->set("breadcrumb2", "Servidores");
	}

	public function index(){		
		$crud = new Grocery_CRUD();
		$crud->set_table("servidor");
		$crud->set_subject("Servidor");
		$crud->display_as("grupo_idgrupo", "Grupo");
		$crud->set_relation("grupo_idgrupo", "grupo", "descricao");
		$crud->columns("nome", "siape");
		$crud->set_relation_n_n("chefe", "chefe", "servidor", "servidor_idservidor", "servidor_chefe", "nome");
		$crud->unset_clone();
		$form = $crud->render();
		$this->template->load("template/restrito",'crud/index', $form);
	}
}