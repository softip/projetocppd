<?php if (!defined('BASEPATH'))  exit('Acesso não permitido');

class Papeis extends CI_Controller {

    var $crud;
    
    function index() {
        $this->crud = new grocery_CRUD();
        $this->crud->set_table('papel');
        $this->crud->set_subject("Papel");        
        $this->crud->columns('papel', 'is_admin', 'permitir_acesso');
        $this->crud->set_relation_n_n("permitir_acesso", "privilegio", "controller", "papel_idpapel", "controller_idcontroller", "descricao");
        $state = $this->crud->getState();
        if ($state == "insert_validation") {
            $this->crud->set_rules('papel', 'Papel', 'required|is_unique[papel.papel]');
        }
        
        $this->crud->display_as('is_admin', 'Administrador Geral');
        
        //$this->crud->callback_before_delete(array($this, 'check_users_in_role'));
        $this->crud->unset_clone();
        $form = $this->crud->render();

        $this->template->set("breadcrumb1", "Cadastros");
        $this->template->set("breadcrumb2", "Papeis");
        $this->template->set("titulo", "Cadastro de Papeis");
        $this->template->load('template/restrito', "crud/index", $form);
    }

    public function check_users_in_role($primary_key) {       
        $this->db->where('papel_idpapel', $primary_key);
        $usuarios = $this->db->get('usuario');

        if ($usuarios->num_rows() > 0) {
            $this->crud->set_lang_string('delete_error_message', 'É necessário excluir todos os usuários antes de excluir um papel');
            return false;
        }
        return true;
    }

}
