<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();		
	}

    public function entrar(){

		$email = $this->input->post("email");
		$senha = $this->input->post("senha");

		$this->db->where("email", $email);
		$this->db->where("senha", $senha);
		$query = $this->db->get("servidor");

		if($query->num_rows() == 1){
			$resultado = $query->row();
			$servidor = array(
				"email" => $resultado->email,
				"nome" => $resultado->nome
			);
			$this->session->set_userdata("usuario", $servidor);
			redirect(site_url("restrito/restrito"));
		}else{
			$this->session->set_flashdata("erro_login", "Usuário o senha inválidos");
			redirect(site_url("home/login"));
		}
	}

	public function sair() {
        $this->session->unset_userdata("usuario");
        redirect(site_url(''));
    }

}
