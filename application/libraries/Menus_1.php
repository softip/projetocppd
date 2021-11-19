<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Menus {

    protected $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    function create_menu() {
        $user = (object) $this->CI->session->userdata('user');
        
        //if($user->tem_licenca_uso == 1){
            if ($this->_isAdminUser($user)) {
                $this->_create_menu_admin();
            } else {
                $this->_create_menu_restrict_papel($user);
            }
        //}
    }

    function _isAdminUser($user) {
        foreach ($user->papeis as $papel) {
            if ($papel->is_admin == 1) {
                return true;
            }
        }
        return false;
    }

    function _create_menu_admin() {
        $menus = $this->CI->db->get("menu")->result();
        $categoriaAtiva = $this->_getCategoriaAtiva();
        foreach ($menus as $menu) {
            $openMenu = ($categoriaAtiva == $menu->categoria) ? "menu-open" : "";
            $openMenu2 = ($categoriaAtiva == $menu->categoria) ? "style='display: block;'" : "";
            printf("<li class='treeview $openMenu'>\n");
            printf( "<a href='#'>\n");
            printf( "<i class='$menu->icone'></i>\n");
            printf( "      <span>$menu->categoria</span>\n");
            printf( "      <span class='pull-right-container'>\n");
            printf( "        <i class='fa fa-angle-left pull-right'></i>\n");
            printf( "      </span>\n");
            printf( "    </a>\n");
            printf( "    <ul class='treeview-menu' $openMenu2> \n");

            $this->CI->db->where("menu_idmenu", $menu->idmenu);
            $this->CI->db->where("mostrar_menu", 1);
            $links = $this->CI->db->get("controller")->result();
            foreach ($links as $link) {
                $linkAtivo = $this->hasActiveLink($link->name);
//removido o obterNotificações
                $notificacao = "";//$this->_obterNoticacoes($link->name);   
                echo "<li $linkAtivo><a href='" . site_url($link->name) . "' ><i class='$link->icone'></i> <span>$link->titulo</span>$notificacao</a></li>";
            }
            echo "    </ul>";
            echo "  </li>";
        }
    }

    function _create_menu_restrict_papel($user) {
        $ids = array_map(function($p) {
            return $p->idpapel;
        }, $user->papeis);
        
        $menus = $this->_getMenuCategoriaRoleRetrict($ids);
        $categoriaAtiva = $this->_getCategoriaAtiva();
        foreach ($menus as $menu) {
            $openMenu = ($categoriaAtiva == $menu->categoria) ? "menu-open" : "";
            $openMenu2 = ($categoriaAtiva == $menu->categoria) ? "style='display: block;'" : "";
            echo "<li class='treeview $openMenu'>";
            echo "<a href='#'>";
            echo "<i class='$menu->icone'></i>";
            echo "      <span>$menu->categoria</span>";
            echo "      <span class='pull-right-container'>";
            echo "        <i class='fa fa-angle-left pull-right'></i>";
            echo "      </span>";
            echo "    </a>";
            echo "    <ul class='treeview-menu' $openMenu2> ";
            $this->_addItensMenu($user, $menu->idmenu);
            echo "    </ul>";
            echo "  </li>";
        }
    }

    private function _addItensMenu($user, $idmenu) {
        $this->CI->db->where("menu_idmenu", $idmenu);
        $this->CI->db->where("mostrar_menu", 1);
        $links = $this->CI->db->get("controller")->result();

        foreach ($links as $link) {
            $linkAtivo = $this->hasActiveLink($link->name);
            $notificacao = $this->_obterNoticacoes($link->name);

            foreach ($user->papeis as $papel) {
                if ($this->CI->zacl->check_acl($papel->papel, $link->name)) {
                    echo "<li $linkAtivo><a href='" . site_url($link->name) . "'><i class='$link->icone'></i> <span>$link->titulo</span>$notificacao</a></li>";
                    break;
                }
            }
        }
    }

    function _getMenuCategoriaRoleRetrict($ids_papeis) {
        $this->CI->db->select("menu.idmenu, menu.categoria, menu.icone");
        $this->CI->db->distinct();
        $this->CI->db->join("privilegio", "privilegio.papel_idpapel = papel.idpapel");
        $this->CI->db->join("controller", "controller.idcontroller = privilegio.controller_idcontroller");
        $this->CI->db->join("menu", "menu.idmenu = controller.menu_idmenu");
        $this->CI->db->where_in("papel.idpapel", $ids_papeis);       
        return $this->CI->db->get("papel")->result();
    }

    function hasActiveLink($url) {
        $urls = explode("/", $url);
        $nameControllerUrl = end($urls);
        $controlador = $this->CI->router->class;
        if ($nameControllerUrl == $controlador) {
            return "class='active'";
        }
        return "";
    }

    function _getCategoriaAtiva() {
        $categoria = array("administracao" => "Administração", "laboratorios" => "Laboratórios", "pesquisadores" => "Pesquisadores", "uac" => "Usuário e Permissão");
        $segmentos = $this->CI->uri->segments;
        $controlador = $this->CI->router->class;
        $key = array_search($controlador, $segmentos);
        if ($key > 0) {
            return $categoria[$segmentos[$key - 1]];
        }
        return "";
    }

    /*
    function _obterNoticacoes($link) {
        switch ($link) {
            case "restrito/pesquisadores/excluidos": return $this->getNumNotificacoes("pesquisador", array("deletado" => 1));
            case "restrito/pesquisadores/atualizados": return $this->getNumNotificacoes("pesquisador", array("atualizado" => 1));
            case "restrito/laboratorios/excluidos": return $this->getNumNotificacoes("laboratorio", array("deletado" => 1));
            case "restrito/laboratorios/atualizados": return $this->getNumNotificacoes("laboratorio", array("atualizado" => 1));
            default: return "";
        }
    }

    function getNumNotificacoes($tabela, $colunas) {
        foreach ($colunas as $coluna => $mark) {
            $this->CI->db->where($coluna, $mark);
        }

        $query = $this->CI->db->get($tabela);
        $num = $query->num_rows();
        if ($num > 0) {
            return "<small class='label pull-right bg-red'>$num</small>";
        }
        return "";
    }
     
     */

}
