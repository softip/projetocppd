<?php

class Checar_acl {

    protected $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    function preDispatch() {
        $user = (object) $this->CI->session->userdata('user');


        $controlador = $this->get_controller_name();
        $metodo = $this->get_method_name();
        $url = implode("/", array_slice($this->CI->uri->segments, 0, 3));

        $permitidoAcesso = false;
        if (!$this->CI->zacl->has($url)) {
            $permitidoAcesso = true;
        } else {
            foreach ($user->papeis as $papel) {
                if ($this->CI->zacl->check_acl($papel->papel, $url)) {
                    $permitidoAcesso = true;
                    break;
                }
            }
        }

        if (!$permitidoAcesso) {
            redirect(site_url("restrito/login"), 'location');
        }
    }

    function get_method_name() {
        $ci = &get_instance();
        return $ci->router->method;
    }

    function get_controller_name() {
        $ci = &get_instance();
        return $ci->router->class;
    }

}
