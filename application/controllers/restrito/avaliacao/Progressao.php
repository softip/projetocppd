<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Progressao extends CI_Controller {

    public function __construct() {
        parent::__construct();       
        $this->load->model("carreira_model", "carreira"); 
        $this->template->set("titulo", "Minhas Progressões");
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Carreiras");
        $this->usuario = (object) $this->session->userdata('user');        
    }

    public function index() {    
        $crud = new Grocery_CRUD();
  
        $crud->set_table("carreira");
        $crud->set_subject("Progressões");
        $crud->where("servidor_idservidor", $this->usuario->idservidor);
        $crud->columns("classe", "nivel", "data_progressao", "status");
        $crud->order_by("data_progressao", "desc");
        $crud->display_as("classe_idclasse", "Classe");
        $crud->display_as("nivel_idnivel", "Nível");
        $crud->display_as("data_progressao", "Data da Progressão");
        $crud->display_as("data_proxima", "Data prevista da próxima progressão");
        $crud->unset_read();
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_clone();

        $crud->callback_column("status", array($this, "_column_status"));
                
        $form = $crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
        
    }

    public function _column_status($value, $row){
        $status = $this->carreira->getStatus($row->idcarreira);
        $requerimento = $this->carreira->getRequerimentoByCarreira($row->idcarreira);
        $processo = $this->carreira->getProcessoAvaliacao($row->idcarreira);
        

        if($status == 'AVALIAÇÃO INICIADA'){  
            if(empty($processo->avaliacao_docente)) {
                return '<a href="'.site_url("restrito/avaliacao/avaliacao_docente/index/$requerimento->idRequerimento/edit/$processo->idavaliacao").'" class="btn btn-success">Fazer Avaliação Docente</a>';
            }else{
                return '<a href="" class="btn btn-warning">Aguarde as outras avaliações</a>';
            }                  
        }
        
        if($status === "ENVIAR REQUERIMENTO RH"){            
            return '<a href="'.site_url("restrito/avaliacao/requerimento/finalizar/$requerimento->idRequerimento").'" class="btn btn-success">Finalizar e Encaminhar requerimento para RH</a>';
        }
        if ($status === "APTO PARA REQUERIMENTO" ){
            return '<a href="'.site_url('restrito/avaliacao/requerimento').'" class="btn btn-success">Fazer Requerimento</a>';
        }else if($status === "Prevista"){
            return '<a href="" class="btn btn-danger">Aguardando o interstício</a>';
        }
        
        return $status;
       
    }

}
