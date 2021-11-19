<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Cloud\Firestore\FirestoreClient;

class Firestore {
    
    var $projeto = 'ifsuldeminas-catalogo';
    var $pathKey = '../private/key_google/ifsuldeminas-catalogo-81aaadbedf15.json';
    //var $pathKey = '/var/www/key_google/ifsuldeminas-catalogo-81aaadbedf15.json';
    var $collection;
    
    public function __construct($param) {
        $this->CI =& get_instance();        
        $db = new FirestoreClient([
            'projectId' => $this->projeto,
            'keyFilePath' => $this->pathKey
        ]);        
        $this->collection = $db->collection($param['collection']);                
    }
    
    public function inserir($array_data){        
        $documentoAdicionado = $this->collection->add($array_data);
        return $documentoAdicionado->id();        
    }
    
    public function atualizar($uuid, $array_data){
        $documento = $this->collection->document($uuid);
        $documento->set($array_data);
    }
    
    public function remover($uuid){
        $documento = $this->collection->document($uuid);
        $documento->delete();
    }
    
    public function obterTodos(){//melhor retornar os documentos e interar no controller,pois nao se sabe a colecao a priori
        $snapshot = $this->collection->documents();
        $alunos = array();
        foreach($snapshot as $aluno){
            $a = (object)[];
            $a->id = $aluno->id();
            $a->nome = $aluno['nome'];
            $alunos[]= $a;
        }
        return $alunos;
    }
}
