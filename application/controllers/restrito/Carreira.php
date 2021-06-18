<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carreira extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//adicionar essa linha para controlar acesso ao controlador
		$this->load->library("controla_acesso");
		
		$this->template->set("titulo", "Cadastro de Carreiras");
		$this->template->set("breadcrumb1", "Cadastros");
		$this->template->set("breadcrumb2", "Carreiras");
	}

    public function index()
	{
		$crud = new Grocery_CRUD();
		$crud->set_table("carreira");
        $crud->display_as("classe_idclasse", "Classe");
		$crud->display_as("nivel_idnivel", "Nível");
		$crud->display_as("servidor_idservidor", "Servidor");
        $crud->set_relation("classe_idclasse", "classe", "classe");
        $crud->set_relation("nivel_idnivel", "nivel", "nivel");
        $crud->set_relation("servidor_idservidor", "servidor", "nome");
		$form = $crud->render();
		$this->template->load("template/restrito",'crud/index', $form);
	}
}
