<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controla_acesso {
		
	function __construct(){               
		$this->CI =& get_instance();
		$usuario = $this->CI->session->userdata("usuario");
		if(!isset($usuario["nome"])){
			redirect(site_url());
		}		
	}
}

/* Location: ./system/application/libraries/Template.php */