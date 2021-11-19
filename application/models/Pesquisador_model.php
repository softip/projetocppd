<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pesquisador_model extends CI_Model {

    public function getGrandeAreasCobertas() {
        $query = $this->db->query("select * from grande_area where grande_area.idgrande_area in 
                                  (select `area`.grande_area_idgrande_area from pesquisador, `area` where pesquisador.area_idarea= `area`.idarea AND pesquisador.removido_app = 0) ORDER BY RAND()");
        return $query->result();
    }

    public function getAreasCobertas($idGrandeArea) {
        $query = $this->db->query("select * from `area` where `area`.idarea in(
                                    select distinct pesquisador.area_idarea from pesquisador WHERE pesquisador.removido_app = 0) 
                                    and `area`.grande_area_idgrande_area = $idGrandeArea ORDER BY RAND()");
        return $query->result();
    }

    public function getPesquisadorByArea($idArea) {
        $this->db->select("idpesquisador, servidor.nome as nome, campi.nome as campus, graduacao, mestrado, doutorado, telefone, lattes, email, servidor.foto as foto_ser, pesquisador.foto as foto_pes, segmento.nome as segmento");
        $this->db->join("servidor", "servidor.idservidor = pesquisador.servidor_idservidor");
        $this->db->join("campi", "campi.idcampi = servidor.campi_idcampi");
        $this->db->join("area", "area.idarea = pesquisador.area_idarea");
        $this->db->join("segmento", "servidor.segmento_idsegmento = segmento.idsegmento");
        $this->db->where("pesquisador.area_idarea", $idArea);
        $this->db->where("pesquisador.removido_app", 0);
        $this->db->order_by("servidor.nome");
        $pesquisadores = $this->db->get("pesquisador")->result();
        foreach ($pesquisadores as $pesquisador) {
            if (!empty($pesquisador->foto_pes)) {
                $pesquisador->foto = $pesquisador->foto_pes;
            } else {
                $pesquisador->foto = $pesquisador->foto_ser;
            }
        }
        return $pesquisadores;
    }

    public function getSubAreas($idPesquisador) {
        $this->db->select("subarea.nome");
        $this->db->distinct();
        $this->db->join("linhas_pesquisa", "subarea.idsubarea = linhas_pesquisa.subarea_idsubarea");
        $this->db->join("pesquisador_linhas_pesquisa", "pesquisador_linhas_pesquisa.linhas_pesquisa_idlinhas_pesquisa = linhas_pesquisa.idlinhas_pesquisa");
        $this->db->where("pesquisador_idpesquisador", $idPesquisador);
        return $this->db->get("subarea")->result();                       
    }

    public function getLinhasPesquisa($idPesquisador) {
        $this->db->select("nome");
        $this->db->join("pesquisador_linhas_pesquisa", "linhas_pesquisa.idlinhas_pesquisa = pesquisador_linhas_pesquisa.linhas_pesquisa_idlinhas_pesquisa");
        $this->db->where("pesquisador_idpesquisador", $idPesquisador);
        return $this->db->get("linhas_pesquisa")->result();
    }

    public function getGrupoPesquisa($idPesquisador) {
        $this->db->select("nome");
        $this->db->join("grupo_pesquisador", "grupo_pesquisa.idgrupo_pesquisa = grupo_pesquisador.grupo_pesquisa_idgrupo_pesquisa");
        $this->db->where("pesquisador_idpesquisador", $idPesquisador);
        return $this->db->get("grupo_pesquisa")->result();
    }
    
    public function getGrupoEstudo($idPesquisador) {
        $this->db->select("nome");
        $this->db->join("pesquisador_grupo_estudo", "pesquisador_grupo_estudo.grupo_estudo_idgrupo_estudo = grupo_estudo.idgrupo_estudo");
        $this->db->where("pesquisador_idpesquisador", $idPesquisador);
        return $this->db->get("grupo_estudo")->result();
    }

    public function getLaboratorios($idPesquisador) {
        $this->db->select("nome");
        $this->db->join("pesquisador_laboratorio", "laboratorio.idlaboratorio = pesquisador_laboratorio.laboratorio_idlaboratorio");
        $this->db->where("pesquisador_idpesquisador", $idPesquisador);
        return $this->db->get("laboratorio")->result();
    }

    public function _getPesquisadorById($idPesquisador) {
        $this->db->select("idpesquisador, servidor.nome as nome, campi.nome as campus, area.nome as area_atuacao, graduacao, mestrado, doutorado, telefone, lattes, email, servidor.foto as foto_ser, pesquisador.foto as foto_pes, uuid");
        $this->db->join("servidor", "servidor.idservidor = pesquisador.servidor_idservidor");
        $this->db->join("campi", "campi.idcampi = servidor.campi_idcampi");
        $this->db->join("area", "area.idarea = pesquisador.area_idarea");
        $this->db->where("pesquisador.idpesquisador", $idPesquisador);

        $pesquisador = $this->db->get("pesquisador")->row();
        if ($pesquisador->foto_pes == null) {
            $pesquisador->foto = $pesquisador->foto_ser;
        } else {
            $pesquisador->foto = $pesquisador->foto_pes;
        }
        unset($pesquisador->foto_ser);
        unset($pesquisador->foto_pes);
        return $pesquisador;
    }

    public function getCatalogoPesquisador() {
        //pesquisa todas as grande areas com pesquisadores        
        $grandes_area = $this->getGrandeAreasCobertas();   
        $this->_enriquecerGrandeArea($grandes_area);
        return $grandes_area;
    }

    public function getPesquisadorById($idPesquisador, $tipo = null) {
        if ($tipo == "array") {
            return $this->getPesquisadorByIdArray($idPesquisador);
        }
        $pesquisador = $this->_getPesquisadorById($idPesquisador);
        $pesquisador->linhas_pesquisa = $this->pesquisador->getLinhasPesquisa($pesquisador->idpesquisador);
        $pesquisador->grupos_pesquisa = $this->pesquisador->getGrupoPesquisa($pesquisador->idpesquisador);
        $pesquisador->grupos_estudo = $this->pesquisador->getGrupoEstudo($pesquisador->idpesquisador);
        $pesquisador->laboratorios = $this->pesquisador->getLaboratorios($pesquisador->idpesquisador);
        $pesquisador->subareas = $this->pesquisador->getSubAreas($pesquisador->idpesquisador);
        return $pesquisador;
    }

    public function getPesquisadorByIdArray($idPesquisador) {
        $pesquisador = $this->_getPesquisadorById($idPesquisador);
        $pesquisador->linhas_pesquisa = (array) $this->pesquisador->getLinhasPesquisa($pesquisador->idpesquisador);
        $pesquisador->grupos_pesquisa = (array) $this->pesquisador->getGrupoPesquisa($pesquisador->idpesquisador);
        $pesquisador->grupos_estudo = $this->pesquisador->getGrupoEstudo($pesquisador->idpesquisador);
        $pesquisador->laboratorios = (array) $this->pesquisador->getLaboratorios($pesquisador->idpesquisador);
        $pesquisador->subareas = (array) $this->pesquisador->getSubAreas($pesquisador->idpesquisador);
        return (array) $pesquisador;
    }

    public function _enriquecerGrandeArea($grandes_area) {
        foreach ($grandes_area as $ga) {
            $ga->areas = $this->pesquisador->getAreasCobertas($ga->idgrande_area);
            $this->_enriquecerArea($ga->areas);
        }
    }

    public function _enriquecerArea($areas) {
        foreach ($areas as $area) {
            $area->pesquisadores = $this->pesquisador->getPesquisadorByArea($area->idarea);
            $this->_enriquecerPesquisadores($area->pesquisadores);
        }
    }

    public function _enriquecerPesquisadores($pesquisadores) {
        foreach ($pesquisadores as $pesquisador) {
            $pesquisador->linhas_pesquisa = $this->pesquisador->getLinhasPesquisa($pesquisador->idpesquisador);
            $pesquisador->grupos_pesquisa = $this->pesquisador->getGrupoPesquisa($pesquisador->idpesquisador);
            $pesquisador->grupos_estudo = $this->pesquisador->getGrupoEstudo($pesquisador->idpesquisador);
            $pesquisador->laboratorios = $this->pesquisador->getLaboratorios($pesquisador->idpesquisador);
            $pesquisador->subAreas = $this->pesquisador->getSubAreas($pesquisador->idpesquisador);
        }
    }

    function set_uuid($idpesquisador, $uuid) {
        $data = array('uuid' => $uuid, 'atualizado' => '0', 'removido_app' => 0);
        $this->db->where('idpesquisador', $idpesquisador);
        $this->db->update('pesquisador', $data);
    }

    function confirma_atualizacao($idpesquisador) {
        $data = array('atualizado' => '0', 'removido_app' => 0);
        $this->db->where('idpesquisador', $idpesquisador);
        $this->db->update('pesquisador', $data);
    }

    function marcaComoRemovido($idpesquisador) {
        $data = array('removido_app' => 1, 'deletado' => 0);
        $this->db->where('idpesquisador', $idpesquisador);
        $this->db->update('pesquisador', $data);
    }

    function marcaParaRemocao($idpesquisador) {
        if (!$this->isRemoved($idpesquisador)) {
           $dados = array("deletado" => 1);
           $this->db->where('idpesquisador', $idpesquisador);
           $this->db->update('pesquisador', $dados);
            return true;
        }
        return false;
    }

    function isRemoved($idpesquisador) {
        $this->db->where('idpesquisador', $idpesquisador);
        $this->db->where('removido_app', 1);
        return !empty($this->db->get("pesquisador")->row());
    }

    function marca_atualizado($post_array, $primary_key) {
        $dados = array("atualizado" => 1);
        $this->db->where("idpesquisador", $primary_key);
        $this->db->update('pesquisador', $dados);
        return true;
    }

    function getPesquisadorByIdUsuario($idusuario) {
        $this->db->join("servidor", "usuario.servidor_idservidor = servidor.idservidor");
        $this->db->join("pesquisador", "pesquisador.servidor_idservidor = servidor.idservidor");
        $this->db->where("idusuario", $idusuario);
        return $this->db->get("usuario")->row();
    }

    function pesquisadorBelongsCampi($idPesquisador, $idcampi) {
        $this->db->join("pesquisador", "pesquisador.servidor_idservidor = servidor.idservidor");
        $this->db->where("campi_idcampi", $idcampi);
        $this->db->where("idpesquisador", $idPesquisador);
        return $this->db->get("servidor")->num_rows() == 1;
    }
    
   

}
