<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Zacl {

    // Set the instance variable
    var $CI;

    function __construct() {
        $this->CI = & get_instance();
        set_include_path(get_include_path() . PATH_SEPARATOR . BASEPATH . "application/libraries");
        require_once(APPPATH . '/libraries/Zend/Acl.php');
        require_once(APPPATH . '/libraries/Zend/Acl/Role.php');
        require_once(APPPATH . '/libraries/Zend/Acl/Resource.php');

        $this->acl = new Zend_Acl();

        $this->getRole();
        $this->getResources();
        $this->getPermissoesRecursos();
        $this->getPermissoesAdmin();
    }

    function getRole() {
        $papeis = $this->CI->db->get('papel')->result();

        foreach ($papeis as $papel) {
            $this->acl->addRole($papel->papel);
        }
    }

    function getResources() {
        $this->CI->db->where('gerenciar = 1');
        $query_pai = $this->CI->db->get('controller');

        foreach ($query_pai->result() AS $row) {
            $this->acl->addResource(new Zend_Acl_Resource($row->name));
        }
    }

    function getPermissoesRecursos() {
        $this->CI->db->join('controller', 'controller.idcontroller = privilegio.controller_idcontroller');
        $this->CI->db->join('papel', 'papel.idpapel = privilegio.papel_idpapel');
        $query_pai = $this->CI->db->get('privilegio');

        foreach ($query_pai->result() as $row) {
            $this->acl->allow($row->papel, $row->name);
//          $this->acl->deny($row->papel, $row->name);
        }
    }

    function getPermissoesAdmin() {
        $this->CI->db->where('is_admin = 1');
        $query_pai = $this->CI->db->get('papel');

        foreach ($query_pai->result() as $row) {
            $this->acl->allow($row->papel, null);
        }
    }

    function check_acl($role, $resource, $method = '') {
        if (!$this->acl->has($resource)) {
            return 1;
        } else {
            return $this->acl->isAllowed($role, $resource, $method);
        }
    }

    function has($resource) {
        return $this->acl->has($resource);
    }

}
