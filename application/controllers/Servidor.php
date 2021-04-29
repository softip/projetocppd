<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servidor extends CI_Controller {

	public function index()
	{
		$crud = new Grocery_CRUD();
		$crud->set_table("servidor");
		$crud->display_as("situacao_idsituacao", "Situação");
		$crud->set_relation("situacao_idsituacao", "situacao", "especificacao");
		$form = $crud->render();
		$this->template->load("template/template1",'crud/index', $form);
	}
}
