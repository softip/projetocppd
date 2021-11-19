<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Alerts {

    function __construct() {
        $this->CI = & get_instance();
        $this->type = array(
          "danger" => array("class" => "alert-danger", "icon" => "fa-ban"), 
          "info" => array("class" => "alert-info", "icon" => "fa-info"), 
          "warning" => array("class" => "alert-warning", "icon" => "fa-warning"), 
          "success" => array("class" => "alert-success", "icon" => "fa-check"), 
        );
    }

    function set($title, $message, $type) {
        $this->CI->session->set_flashdata('alert', array("title" => $title, "message" => $message, "type" => $type));
    }

    function show() {
        $dados = (object) $this->CI->session->flashdata('alert');    
        if (!empty($dados->title)) {
            echo "<div class='box-body'>
                    <div class='alert ".$this->type[$dados->type]["class"]." alert-dismissible'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                      <h4><i class='icon fa ".$this->type[$dados->type]["icon"]."'></i> $dados->title</h4>
                      $dados->message
                    </div>              
                  </div>  ";
        }
    }

}
