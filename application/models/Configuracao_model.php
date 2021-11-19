<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracao_model extends CI_Model {
    
    public function getLicencaUso() {
        $this->db->select("titulo_termo as titulo, texto_termo as texto");        
        $this->db->where("idconfiguracoes", 1);
        return $this->db->get("configuracoes")->row();
    }
    
}
