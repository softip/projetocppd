<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    var $crud;

    public function __construct() {
        parent::__construct();
        $this->usuario = $this->session->userdata("user");
        if (!isset($this->usuario)) {
            redirect(site_url('restrito/login'));
        }
        $this->crud = new Grocery_CRUD();
    }

    protected function _auth() {
        if ($this->usuario['nivel'] == 'Particular') {
            $this->_editDadosParticulares();
            $this->crud->unset_add();
            $this->crud->unset_delete();
            $this->crud->unset_edit();
            $this->crud->where("idusuario", $this->usuario['idusuario']);   
            $this->crud->set_relation_n_n("papeis", "papel_usuario", "papel", "usuario_idusuario", "papel_idpapel", "papel"); 
        } else if ($this->usuario['nivel'] == 'Campus') {
            $this->_editDadosCampi();
            $this->crud->where("campi_idcampi", $this->usuario['idcampi']);
            $this->crud->set_relation_n_n("papeis", "papel_usuario", "papel", "usuario_idusuario", "papel_idpapel", "papel", null, "idpapel in (2,3,4)");
            $this->crud->field_type('nivel','dropdown', array('Particular' => 'Particular', 'Campus' => 'Campus'));
        } else if ($this->usuario['nivel'] == 'Geral') {
           $this->crud->set_relation_n_n("papeis", "papel_usuario", "papel", "usuario_idusuario", "papel_idpapel", "papel"); 
        }
    }

    protected function _editDadosParticulares() {
        $idEdit = end($this->uri->segments);
        if (is_numeric($idEdit) && $idEdit != $this->usuario['idusuario']) {
            redirect(site_url("restrito/uac/usuario"));
        }
    }
    
    protected function _editDadosCampi() {
        $idEdit = end($this->uri->segments);        
        if (is_numeric($idEdit) && !$this->_userBelongsCampi($idEdit, $this->usuario['idcampi'])) {
            redirect(site_url("restrito/uac/usuario"));
        }
    }
    
    protected function _userBelongsCampi($iduser, $idcampi){
        $this->db->join("servidor","usuario.servidor_idservidor = servidor.idservidor");
        $this->db->where("campi_idcampi",$idcampi);
        $this->db->where("idusuario",$iduser);
        return $this->db->get("usuario")->num_rows() == 1;
    }
    

    public function index() {
        $this->_auth();
        $this->crud->set_table("usuario");
        $this->crud->set_subject("Usuário","Usuários");
        $this->crud->set_relation("servidor_idservidor", "servidor", "nome");
        
        $this->crud->columns("servidor_idservidor", "papeis", "nivel");

        $this->crud->display_as("servidor_idservidor", "Servidor");
        $this->crud->display_as("papeis", "Papéis");
        $this->crud->display_as("confirmar_senha", "Confirmar Senha");
        $this->crud->display_as("nivel", "Nível de acesso");
        $this->crud->add_action('Alterar Senha', '', 'restrito/uac/usuario/change_password/edit', 'fas fa-unlock-alt');

        $state = $this->crud->getState();
        if ($state == "insert_validation") {
            $this->crud->set_rules('servidor_idservidor', 'Servidor', 'required|is_unique[usuario.servidor_idservidor]');
        }

        if ($state == "edit" || $state == "update" || $state == "update_validation") {
            $this->crud->fields("servidor_idservidor", "papeis", "nivel");
            $this->crud->required_fields("servidor_idservidor", "nivel", "papeis");
        } else {
            $this->crud->fields("servidor_idservidor", "senha", "confirmar_senha", "papeis", "nivel");
            $this->crud->field_type("senha", "password");
            $this->crud->field_type("confirmar_senha", "password");
            $this->crud->required_fields("servidor_idservidor", "senha", "confirmar_senha", "nivel", "papeis");
            $this->crud->set_rules('senha', 'Confirmar Senha', 'required|matches[confirmar_senha]');
            $this->crud->callback_before_insert(array($this, '_inserir'));
        }

        $this->crud->unset_clone();
        $this->crud->unset_read();

        $form = $this->crud->render();
        //envio de dados para template
        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Usuário");
        $this->template->set("titulo", "Cadastro de Usuários");
        $this->template->load('template/restrito', "crud/index", $form);
    }

    function change_password() {
        $this->_auth();
        $this->crud = new Grocery_CRUD();
        $this->crud->set_table("usuario");
        $this->crud->unset_add();
        $this->crud->unset_list();
        $this->crud->unset_read();
        $this->crud->unset_delete();
        $this->crud->fields("senha", "confirmar_senha");
        $this->crud->display_as("confirmar_senha", "Confirmar Senha");
        $this->crud->field_type("senha", "password");
        $this->crud->field_type("confirmar_senha", "password");
        $this->crud->required_fields("senha", "confirmar_senha");
        $this->crud->set_rules('senha', 'Confirmar Senha', 'required|matches[confirmar_senha]');
        $this->crud->callback_before_update(array($this, '_inserir'));
        $this->crud->unset_back_to_list();
        $this->crud->set_lang_string('update_success_message',
		 'Senha atualizada com sucesso.
		 <script type="text/javascript">
		  window.location = "'.site_url("/restrito/uac/usuario").'";
		 </script>
		 <div style="display:none">
		 '
        );
        $form = $this->crud->render();
        $this->template->set("menu", "Cadastros");
        $this->template->set("submenu", "Usuário");
        $this->template->load('templates/index', "templates/crud/index", $form);
    }

    function _inserir($post_array) {
        $post_array["senha"] = md5($post_array["senha"]);
        unset($post_array["confirmar_senha"]);
        return $post_array;
    }

}
