<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Servidor_model extends CI_Model {
    public function getNome($id) {
        $this->db->select("nome");
        $this->db->where("idservidor", $id);
        return $this->db->get("servidor")->row();
    }

    public function find($id) {        
        $this->db->where("idservidor", $id);
        return $this->db->get("servidor")->row();
    }
}
