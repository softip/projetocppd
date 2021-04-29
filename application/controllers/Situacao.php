<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Situacao extends CI_Controller {

	public function index()
	{
		$crud = new Grocery_CRUD();
		$crud->set_table("situacao");	
		$form = $crud->render();
		$this->template->load("template/template1",'crud/index', $form);
	}

}
