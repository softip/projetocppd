<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requerimento extends CI_Controller {

    public function __construct() {
        parent::__construct();        
        $this->template->set("titulo", "Requerimento de Progressão");
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Avaliação");
        $this->usuario = (object) $this->session->userdata('user');  
        $this->load->model("carreira_model", "carreira");         
    }

    public function index() {    
        $crud = new Grocery_CRUD();
  
        $crud->set_table("requerimento");
        $crud->set_subject("Requerimento");  
        $crud->columns("servidor_idservidor","carreira_idcarreira","data", "status");
        $crud->display_as("carreira_idcarreira", "Classe/Nível");
        $crud->display_as("servidor_idservidor", "Servidor");
        //$crud->unset_read();
        //$crud->unset_edit();
        //$crud->unset_delete();
        $crud->unset_clone();
        //$crud->unset_list();
        $crud->fields("carreira_idcarreira", "texto", "servidor_idservidor"); 
        
              
        $this->load->model("carreira_model", "carreira");
        $idCarreira =  $this->carreira->getIdNextProgression($this->usuario->idservidor);
        if(!$idCarreira){
            $crud->unset_add();
        }
        $crud->field_type("carreira_idcarreira", "hidden", $idCarreira);
        $crud->field_type("servidor_idservidor", "hidden", $this->usuario->idservidor);
        
        if( in_array($crud->getState(),["list", "success","ajax_list"]) ){
           $crud->set_relation("servidor_idservidor", "servidor", "nome");
           $crud->set_relation("carreira_idcarreira", "carreira", "{classe}/{nivel}");
        }

        $crud->field_type("texto", "text", $this->_modelo());
        $crud->callback_column("status", array($this, "_column_status"));

        $form = $crud->render();
        $this->template->load("template/restrito", 'crud/index', $form);
        
    }

    public function _modelo(){
        $this->load->model("servidor_model", "servidor");
        $servidor =  $this->servidor->find($this->usuario->idservidor);
        $dia = date("d");
        $mes = array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
        $mes = $mes[date("m")-1];
        $ano = date("Y");
        $brasao = base_url("recursos/img/brasao.gif");
        $m = <<<EOL
            <p style="text-align: center;">
            <img alt="" src="$brasao" width="100px"/></p>
            <p style="text-align: center;">
            <strong>Minist&eacute;rio da Educa&ccedil;&atilde;o<br />
            Secretaria de Educa&ccedil;&atilde;o Profissional e Tecnol&oacute;gica<br />
            Instituto Federal de Educa&ccedil;&atilde;o, Ci&ecirc;ncia e Tecnologia do Sul de Minas Gerais<br />
            IFSULDEMINAS - Campus Inconfidentes<br />
            Pra&ccedil;a Tiradentes, 416, Centro, INCONFIDENTES / MG, CEP 37.576-000 - Fone: (35) 3464-1200</strong></p>
        <p>
            &nbsp;</p>
        <p style="text-align: center;">
            <strong>REQUERIMENTO DE PROGRESS&Atilde;O/PROMO&Ccedil;&Atilde;O FUNCIONAL POR DESEMPENHO ACAD&Ecirc;MICO</strong></p>
        <p style="text-align: center;">
            &nbsp;</p>
        <table border="1" cellpadding="1" cellspacing="1" style="width:100%;">
            <tbody>
                <tr>
                    <td colspan="2">
                        <p style="text-align: center;">
                            <strong>Dados Pessoais</strong></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Nome</strong>: {$this->usuario->nome}</td>
                    <td>
                        &nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <strong>Matr&iacute;cula</strong>: {$servidor->matricula}</td>
                    <td>
                        <strong>Locata&ccedil;&atilde;o</strong>: xxxx</td>
                </tr>
                <tr>
                    <td>
                        <strong>Cargo/Emprego</strong>: xxxx</td>
                    <td>
                        <strong>CPF</strong>:XXXX</td>
                </tr>
            </tbody>
        </table>
        <p>
            &nbsp;</p>
        <p style="text-align: center;">
            &nbsp;</p>
        <p style="text-align: center;">
            Vem requerer ao senhor(a) Diretor(a)-Geral/magn&iacute;fico(a) Reitor(a):</p>
        <p>
            ( ) Progress&atilde;o funcional docente.</p>
        <p>
            ( ) Promo&ccedil;&atilde;o docente.</p>
        <p>
            Observa&ccedil;&atilde;o: progress&atilde;o &eacute; a passagem do servidor para o n&iacute;vel de vencimento imediato superior dentro de uma mesma classe. Exemplo: DII 01 - DII 02. Promo&ccedil;&atilde;o &eacute; a passagem do servidor de uma classe para outra subsequente. Exemplo: DII 02 - DIII 01.</p>
        <p>
            Fundamento Legal: Lei no 12.772, de 28 de dezembro de 2012, Portaria do MEC no 554, de 20 de junho de 2013 e Resolu&ccedil;&atilde;o no 23/2013CONSUP/IFSULDEMINAS.</p>
            <p style="text-align: center;">
                   Inconfidentes, $dia de $mes de $ano
                   </p>
            
        EOL;
     return $m;
    }

    public function _column_status($value, $row){
        $status = $this->carreira->getStatus($row->carreira_idcarreira);
        $processo = $this->carreira->getProcessoAvaliacao($row->carreira_idcarreira);
        
        if($status == 'AVALIAÇÃO INICIADA'){
            if(empty($processo->avaliacao_docente)) {
                return '<a href="'.site_url("restrito/avaliacao/avaliacao_docente/index/$row->idRequerimento/edit/$processo->idavaliacao").'" class="btn btn-success">Fazer Avaliação Docente</a>';
            }else{
                return '<a href="" class="btn btn-warning">Aguarde as outras avaliações</a>';
            }                        
        }
        
        if ($status == 'ENVIAR REQUERIMENTO RH'){            
            return '<a href="'.site_url("restrito/avaliacao/requerimento/finalizar/$row->idRequerimento").'" class="btn btn-success">Finalizar e Encaminhar requerimento para RH</a>';
        } 
        return $status;
    }

    public function finalizar($id){
        $this->db->where("idRequerimento", $id);
        $this->db->update("requerimento",array('status' => 'AGUARDANDO RECEBIMENTO PELO RH'));
        redirect(site_url("restrito/avaliacao/requerimento"));
    }

}
