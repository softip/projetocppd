<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{
                  
    public function __construct() {
        parent::__construct();
        $this->usuario = $this->session->userdata("user");
        if (!isset($this->usuario)) {
            redirect(site_url('restrito/login'));
        }
    }

    public function index() {          
        $this->template->set("breadcrumb1", "Restrito");
        $this->template->set("breadcrumb2", "Dashboard");
        $this->template->set("titulo", "Dashboard");
        $this->template->load("template/restrito",'template/restrito_main');
    }
    
    public function aceitacao(){
        $dados = array("autoriza_uso" => 1);
        $this->db->where("idusuario", $this->usuario["idusuario"]);
        $this->db->update("usuario", $dados);
        $this->usuario["tem_licenca_uso"] = 1;
        $this->session->set_userdata("user", $this->usuario);
        redirect(site_url("restrito/administracao/dashboard"));
    }
    
}

