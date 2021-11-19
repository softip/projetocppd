<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Cloud\Storage\StorageClient;

class Storage {

    var $projeto = 'ifsuldeminas-catalogo';
    var $pathKey = '../private/key_google/ifsuldeminas-catalogo-81aaadbedf15.json';
    var $url_bucket = 'ifsuldeminas-catalogo.appspot.com';

    public function __construct() {
        
        $this->CI = & get_instance();

        // Enable Storage
        $this->storage = new StorageClient([
            'projectId' => $this->projeto,
            'keyFilePath' => $this->pathKey
        ]);
        // Reference an existing bucket.
        $this->bucket = $this->storage->bucket('ifsuldeminas-catalogo.appspot.com');
    }

    public function uploadPesquisador($pesquisador) {
        $file = fopen("assets/uploads/pesquisadores/$pesquisador->foto", 'r');
        $filename_array = explode(".", $pesquisador->foto);
        $file_extension = end($filename_array);
        $object = $this->bucket->upload($file, [
            'name' => "pesquisador/$pesquisador->uuid.$file_extension"
        ]);
    }

    public function deleteFotoPesquisador($pesquisador) {
        $filename_array = explode(".", $pesquisador->foto);
        $file_extension = end($filename_array);
        $object = $this->bucket->object("pesquisador/$pesquisador->uuid.$file_extension");
        $object->delete();
    }

    public function deleteFotosLaboratorio($lab_array) {
        $laboratorio = (object) $lab_array;
        if (!empty($laboratorio->uuid)) {
            if (!empty($laboratorio->foto)) {
                $object = $this->bucket->object("laboratorio/$laboratorio->uuid/$laboratorio->foto");
                $object->delete();
            }
            foreach ($laboratorio->fotos as $foto) {
                $object = $this->bucket->object("laboratorio/$laboratorio->uuid/$foto->foto");
                $object->delete();
            }
        }
    }

    public function uploadFotosLaboratorio($idLaboratorio) {
        $this->CI->db->where('idlaboratorio', $idLaboratorio);
        $laboratorio = $this->CI->db->get('laboratorio')->row();
        //Envia a foto de capa 
        if (!empty($laboratorio->foto)) {
            $this->_execUploadFotosLab($laboratorio->foto, $laboratorio->uuid);
        }

        
        $this->CI->db->where('laboratorio_idlaboratorio', $idLaboratorio);
        $fotos = $this->CI->db->get('foto')->result();
        //Envia as demais fotos 
        foreach ($fotos as $foto) {
            $this->_execUploadFotosLab($foto->foto, $laboratorio->uuid);
        }
    }

    public function _execUploadFotosLab($foto, $uuid) {
        $file = fopen("assets/uploads/laboratorios/$foto", 'r');
        $object = $this->bucket->upload($file, array('name' => "laboratorio/$uuid/$foto"));
    }

    function downloadFotoPesquisador($idPesquisador) {
        $this->CI->db->where('idpesquisador', $idPesquisador);
        $pesquisador = $this->CI->db->get('pesquisador')->row();
        $object = $this->bucket->object("pesquisador/$pesquisador->uuid.jpg");
        $object->downloadToFile("/var/www/fotos/$pesquisador->foto");
    }

}
