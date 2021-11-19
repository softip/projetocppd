<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Change_linhas {

    function __construct() {
        $this->CI = & get_instance();
    }
           
    function change_linhas_add() {
        $field = "<select id='field-linhas_pesquisas' name='linhas_pesquisas[]' multiple='multiple' size='8' class='chosen-multiple-select' data-placeholder='Selecione Linhas pesquisas' style='width:510px;'>";
        $field .= "</select>";
        return $field;
    }
    
    function change_linhas_edit() {
        $pesquisador = $this->getPesquisador();
        $options = "";
        if(!empty($pesquisador)){
           $mylinhas = $this->getLinhasPesquisadorEdit($pesquisador->idpesquisador);
           $options =   $this->generateOptions($pesquisador->area_idarea, $mylinhas);         
        }
                
        $field = "<select id='field-linhas_pesquisas' name='linhas_pesquisas[]' multiple='multiple' size='8' class='chosen-multiple-select' data-placeholder='Selecione Linhas pesquisas' style='width:510px;'>";
        $field .= $options;
        $field .= "</select>";
        return $field;
}

    function getPesquisador() {
        $idEdit = end($this->CI->uri->segments);
        if (is_numeric($idEdit)) {
            $this->CI->db->where('idpesquisador', $idEdit); //garantir que é um pesquisador
            return $this->CI->db->get('pesquisador')->row();
        }
    }
    
    function getLinhasPesquisadorEdit($idpesquisador) {
        $this->CI->db->select("linhas_pesquisa_idlinhas_pesquisa as idlinha");
        $this->CI->db->where("pesquisador_idpesquisador", $idpesquisador);
        return $this->CI->db->get("pesquisador_linhas_pesquisa")->result();
    }

    function generateOptions($idarea, $linhasSelected) {
        $options = "";
        if (!empty($idarea)){
            $this->CI->db->where("area_idarea", $idarea);
        }
        $subareas = $this->CI->db->get("subarea")->result();
        $idsLinhas = array_column($linhasSelected, 'idlinha');

        foreach ($subareas as $subarea) {
            $options .= "<optgroup label='$subarea->nome'>";
            $this->CI->db->where("subarea_idsubarea", $subarea->idsubarea);
            $linhas = $this->CI->db->get("linhas_pesquisa")->result();
            foreach ($linhas as $linha) {
                $selected = in_array($linha->idlinhas_pesquisa, $idsLinhas) ? 'selected' : '';
                $options .= "<option value='$linha->idlinhas_pesquisa' $selected >$linha->nome</option>";
            }
            $options .= "</optgroup>";
        }
        return $options;
    }
    
}
