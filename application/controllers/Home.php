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
		$this->template->load("template_site/home",'site/form_login');
	}
    public function progressao()	{
		$this->template->load("template_site/home",'/site/servicos/progressao');
	}
	public function afastamento()	{
		$this->template->load("template_site/home",'/site/servicos/afastamento');
	}
	public function normativa()	{
		$this->template->load("template_site/home",'/site/servicos/normativa');
	}
	public function rsc()	{
		$this->template->load("template_site/home",'/site/servicos/rsc');
	}
	
}
