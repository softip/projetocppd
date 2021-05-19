<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->template->set("titulo", "Cadastro de Avaliações");
		$this->template->set("breadcrumb1", "Cadastros");
		$this->template->set("breadcrumb2", "Avaliações");
	}

    public function index()	{
		$this->template->load("template_site/home",'site/home');
	}

    public function tabelas()	{
		$this->template->load("template_site/home",'site/tabelas');
	}

    public function documentos()	{
		$this->template->load("template_site/home",'site/documentos');
	}

    public function login()	{
		$this->template->load("template_site/home",'site/restrito');
	}
}
