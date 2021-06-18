<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restrito extends CI_Controller {

	public function __construct(){
		parent::__construct();

		//adicionar essa linha para controlar acesso ao controlador
		$this->load->library("controla_acesso");
		
		$this->template->set("titulo", "Sistema CPPD");
		$this->template->set("breadcrumb1", "Restrito");
		$this->template->set("breadcrumb2", "Inicio");
	}

    public function index()
	{		
		$this->template->load("template/restrito",'template/restrito_main');
	}
}
