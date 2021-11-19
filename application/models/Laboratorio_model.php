<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Laboratorio_model extends CI_Model {

    public function getCatalogoOrderByCampi(){
        $campi = $this->getCampiHasLaboratorio();
        foreach($campi as $campus){
            $this->_enriquecerComLaboratorios($campus);
        }
        return $campi;
    }
    
    public function getCampiHasLaboratorio() {
        $query = $this->db->query("select * from campi where campi.idcampi in (
                 select distinct laboratorio.campi_idcampi from laboratorio where area_idarea <> 0 ) order by nome");
        return $query->result();
    }
    
    public function getLaboratoriosByCampus($idCampus) {
        $this->db->select("idlaboratorio,laboratorio.nome,campi.nome as campus, area.nome as area,laboratorio.objetivo,laboratorio.servicos, laboratorio.foto, laboratorio.responsavel_idservidor");
        $this->db->join("area","area.idarea = laboratorio.area_idarea");
        $this->db->join("campi","campi.idcampi = laboratorio.campi_idcampi");
        $this->db->where("campi_idcampi",$idCampus);
        $this->db->where("removido_app",0);
        return $this->db->get("laboratorio")->result();
    }
    
    public function getCursos($laboratorio){
        $this->db->select("idcurso, nome, tipo");
        $this->db->join("laboratorio_curso", "curso.idcurso = laboratorio_curso.curso_idcurso");
        $this->db->where("laboratorio_curso.laboratorio_idlaboratorio", $laboratorio->idlaboratorio);        
        return $this->db->get("curso")->result();
    }
    
    public function getResponsavel($laboratorio){
        $this->db->select("nome, email, telefone");
        $this->db->where("idservidor", $laboratorio->responsavel_idservidor);
        return $this->db->get("servidor")->row();
    }
    
    public function getFotos($laboratorio){
        $this->db->select("foto");
        $this->db->where("laboratorio_idlaboratorio", $laboratorio->idlaboratorio);
        return $this->db->get("foto")->result();
    }
    
    public function getEquipamentos($laboratorio){
        $this->db->select("idequipamento, nome, quantidade");
        $this->db->join("laboratorio_equipamento", "equipamento.idequipamento = laboratorio_equipamento.equipamento_idequipamento");
        $this->db->where("laboratorio_equipamento.laboratorio_idlaboratorio", $laboratorio->idlaboratorio);        
        return $this->db->get("equipamento")->result();
    }

    public function _getLaboratorioById($idLaboratorio){
        $this->db->select("idlaboratorio,laboratorio.nome,campi.nome as campus, area.nome as area,laboratorio.objetivo,laboratorio.servicos, laboratorio.foto, uuid, laboratorio.responsavel_idservidor");
        $this->db->join("area","area.idarea = laboratorio.area_idarea");
        $this->db->join("campi","campi.idcampi = laboratorio.campi_idcampi");
        $this->db->where("idlaboratorio",$idLaboratorio);
        return $this->db->get("laboratorio")->row();
    }
    
    public function getLaboratorioById($idLaboratorio, $tipo=null){
        if($tipo == "array"){
           return $this->getLaboratorioByIdArray($idLaboratorio);
        }
        
        $laboratorio = $this->_getLaboratorioById($idLaboratorio);
        $this->_enriquecerComResponsaveis($laboratorio);
        $this->_enriquecerComCursos($laboratorio);
        $this->_enriquecerComEquipamentos($laboratorio);
        $this->_enriquecerComFotos($laboratorio);
        unset($laboratorio->responsavel_idservidor);
        return $laboratorio;
    }
    
     public function getLaboratorioByIdArray($idLaboratorio){
        $laboratorio = $this->_getLaboratorioById($idLaboratorio);
        $laboratorio->responsavel = (array) $this->getResponsavel($laboratorio);
        $laboratorio->cursos = (array) $this->getCursos($laboratorio);
        $laboratorio->equipamentos = (array) $this->getEquipamentos($laboratorio);
        $laboratorio->fotos = (array) $this->getFotos($laboratorio);  
        unset($laboratorio->responsavel_idservidor);
        return (array) $laboratorio;
    }
    
    
    public function _enriquecerComLaboratorios($campus){
        $campus->laboratorios = $this->getLaboratoriosByCampus($campus->idcampi);
        foreach($campus->laboratorios as $laboratorio){
            $this->_enriquecerComResponsaveis($laboratorio);
            $this->_enriquecerComCursos($laboratorio);
            $this->_enriquecerComEquipamentos($laboratorio);
            $this->_enriquecerComFotos($laboratorio);
        }
    }
    
    public function _enriquecerComResponsaveis($laboratorio){
        $laboratorio->responsavel = $this->getResponsavel($laboratorio);
    }
    
    public function _enriquecerComCursos($laboratorio){
        $laboratorio->cursos = $this->getCursos($laboratorio);
    }
    
    public function _enriquecerComEquipamentos($laboratorio){
        $laboratorio->equipamentos = $this->getEquipamentos($laboratorio);
    }
    
    public function _enriquecerComFotos($laboratorio){
        $laboratorio->fotos = $this->getFotos($laboratorio);
    }
    
    function set_uuid($idlaboratorio, $uuid) {
        $data = array('uuid' => $uuid, 'atualizado'=>'0', 'removido_app' => 0);
        $this->db->where('idlaboratorio', $idlaboratorio);
        $this->db->update('laboratorio', $data);        
    }

    function confirma_atualizacao($idlaboratorio) {
        $data = array('atualizado'=>'0', 'removido_app' => 0);
        $this->db->where('idlaboratorio', $idlaboratorio);
        $this->db->update('laboratorio', $data);        
    }
    
    function marcaComoRemovido($idlaboratorio) {
        $data = array('removido_app' => 1, 'deletado' => 0);
        $this->db->where('idlaboratorio', $idlaboratorio);
        $this->db->update('laboratorio', $data);
    }
    
    function marcaParaRemocao($idlaboratorio) {
        if (!$this->isRemoved($idlaboratorio)) {
           $dados = array("deletado" => 1);
           $this->db->where('idlaboratorio', $idlaboratorio);
           $this->db->update('laboratorio', $dados);
            return true;
        }
        return false;
    }

    function isRemoved($idlaboratorio) {
        $this->db->where('idlaboratorio', $idlaboratorio);
        $this->db->where('removido_app', 1);
        return !empty($this->db->get("laboratorio")->row());
    }
    
    function marca_atualizado($post_array, $primary_key) {
        $data = array('atualizado'=>'1');
        $this->db->where('idlaboratorio', $primary_key);
        $this->db->update('laboratorio', $data);           
        return true;
    }
    
    public function isResponsavel($usuario, $idlaboratorio){
        $this->db->where("responsavel_idservidor", $usuario['idservidor']);
        $this->db->where("idlaboratorio", $idlaboratorio);
        return $this->db->get("laboratorio")->row();
    }
    
    public function belongsCampi($usuario, $idlaboratorio){
        $this->db->where("campi_idcampi", $usuario['idcampi']);
        $this->db->where("idlaboratorio", $idlaboratorio);
        return $this->db->get("laboratorio")->row();
    }
    
    
}
