<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

//$hook['post_controller_constructor'][] = array(
//        'class'    => 'Controle_acesso',
//        'function' => 'preDispatch',
//        'filename' => 'Controle_acesso.php',
//        'filepath' => 'hooks',
//        'params'   => ''
//);

$hook['post_controller_constructor'][] = array(
		'class'    => 'Checar_acl',
		'function' => 'preDispatch',
		'filename' => 'Checar_acl.php',
		'filepath' => 'hooks'
);