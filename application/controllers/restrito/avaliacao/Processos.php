<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Processos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->usuario = (object) $this->session->userdata('user'); 
        $this->load->model("carreira_model", "carreira");
        $this->template->set("titulo", "Avaliações de progressão");
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Avaliações");
        $this->crud = new Grocery_CRUD();        
        $this->crud->set_table("avaliacao");
        $this->crud->set_subject("Processos");
        $this->crud->display_as("carreira_idcarreira", "Carreira");
        $this->crud->display_as("servidor_idservidor", "Servidor");
        $this->crud->display_as("numero_processo", "Informe o Número do Processo");
        $this->crud->display_as("data_abertura", "Data de Abertura");
        $this->crud->display_as("data_homologacao", "Data de Homologação");
        $this->crud->display_as("avaliacao_discente", "Avaliação Discente");
        $this->crud->display_as("avaliacao_docente", "Avaliação Docente");
        $this->crud->display_as("avaliacao_chefia", "Avaliação da Chefia Imediata");
        $this->crud->display_as("Requerimento_idRequerimento", "Requerimento");
        $this->crud->unset_add();
        $this->crud->unset_delete();
        
    }

    public function index() {   
        if( in_array($this->crud->getState(),["list", "success","ajax_list", "read"]) ){
           $this->crud->unset_edit();             
           $this->crud->columns("servidor_idservidor", "carreira_idcarreira", "numero_processo", "data_abertura", "status" );
        }else if(in_array($this->crud->getState(),["edit", "update", "upload_file", "update_validation"])) {
            $this->crud->fields("numero_processo", "servidor_idservidor", "carreira_idcarreira", "avaliacao_chefia","avaliacao_docente","avaliacao_discente", "data_homologacao", "efeitos_financeiros");
            $this->crud->field_type("numero_processo", "readonly");
            $this->crud->field_type("servidor_idservidor", "readonly");
            $this->crud->field_type("carreira_idcarreira", "readonly");
            $this->crud->field_type("avaliacao_chefia", "readonly");
            $this->crud->field_type("avaliacao_docente", "readonly");
            $this->crud->field_type("avaliacao_discente", "readonly");
        }
        $this->crud->set_relation("servidor_idservidor", "servidor", "nome");
        $this->crud->set_relation("carreira_idcarreira", "carreira", "{classe}/{nivel}");
        $this->crud->display_as("numero_processo", "Número do Processo");
        $this->crud->callback_column("status", array($this, "_column_status"));         
        $this->crud->callback_after_update(array($this, '_add_nova_progressao'));
        $this->crud->set_field_upload("avaliacao_chefia");          
        $this->crud->set_field_upload("avaliacao_docente"); 
        $this->crud->set_field_upload("avaliacao_discente"); 
        $form = $this->crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
    }


    function _add_nova_progressao($post_array,$primary_key){
        //pega o processo de avaliacao
        $this->db->where("idavaliacao", $primary_key);
        $processo = $this->db->get("avaliacao")->row();

        //atualiza o status do processo para homologado
        $this->db->where("idavaliacao", $primary_key);
        $this->db->update("avaliacao", array("status" => "HOMOLOGADO"));

        //atualiza o status da progressao/carreira para finalizada
        $dataHomologacao = DateTime::createFromFormat('d/m/Y', $post_array["data_homologacao"]);
        $this->db->where("idcarreira", $processo->carreira_idcarreira);
        $this->db->update("carreira", array("status" => "Finalizada", "data_progressao" =>$dataHomologacao->format("Y-m-d")));

        //pega a avaliacao anteiror        
        $this->db->where("idcarreira", $processo->carreira_idcarreira);
        $carreira = $this->db->get("carreira")->row();
        $proximoNivel = $this->_nextClasse($carreira->classe.$carreira->nivel);
        
        //faz uma nova previsao de progressao
        if($proximoNivel){
            $novaData = DateTime::createFromFormat('d/m/Y', $post_array["efeitos_financeiros"]);
            $novaData->modify('+2 years');           
            $dados = array(
                "servidor_idservidor" => $processo->servidor_idservidor,
                "classe" => $proximoNivel["classe"],
                "nivel" => $proximoNivel["nivel"],
                "data_progressao" =>  $novaData->format("Y-m-d"),
                "status" => "Prevista"
            );
            $this->db->insert('carreira',$dados);
        }
        return true;
    }

    private function _nextClasse($atual){
        $carreira = array(
            "DI1" => array("classe"=>"DI", "nivel"=>"2"),
            "DI2" => array("classe"=>"DII", "nivel"=>"1"),
            "DII1" => array("classe"=>"DII", "nivel"=>"2"),
            "DII2" => array("classe"=>"DIII", "nivel"=>"1"),
            "DIII1" => array("classe"=>"DIII", "nivel"=>"2"),
            "DIII2" => array("classe"=>"DIII", "nivel"=>"3"),
            "DIII3" => array("classe"=>"DIII", "nivel"=>"4"),
            "DIII4" => array("classe"=>"DIV", "nivel"=>"1"),
            "DIV1" => array("classe"=>"DIV", "nivel"=>"2"),
            "DIV2" => array("classe"=>"DIV", "nivel"=>"3"),
            "DIV3" => array("classe"=>"DIV", "nivel"=>"4"),
            "DIV4" => array("classe"=>"Titular", "nivel"=>"Único"),
            "Titular1"=> null
        );
        return $carreira[$atual];
    }

    public function _column_status($value, $row){
        $status =  $this->carreira->getStatus($row->carreira_idcarreira);        
        if ($status == "AGUARDANDO HOMOLOGAÇÃO" && $this->_isRH($this->usuario)){
            return '<a href="'.site_url("restrito/avaliacao/processos/index/edit/$row->idavaliacao").'" class="btn btn-success">Homologar Processo</a>';
        }
        return $status;
    }

    private function _isRH($usuario){
        foreach($usuario->papeis as $role){
            if($role->papel === "RH"){
                return true;
            }
            return false;
        }
    }

}
